<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Gateway;
use App\Models\Order;
use App\Traits\Notifications;
use Session;
use Auth;
use DB;
use Storage;
class SubscriptionController extends Controller
{
    use Notifications;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::where('status',1)->where('price','>',0)->latest()->get();

        return view('user.subscription.index',compact('plans'));
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan     = Plan::where('status',1)->where('price','>',0)->where('id',$id)->first();
        
        if (empty($plan)) {
           Session::flash('saas_error',__('Please select a plan from here')); 
           return redirect('/user/subscription');
        }

        if ($plan->price <= 0) {
          Session::flash('saas_error',__('Please select a plan from here'));

          return redirect('/user/subscription');
        }

        $gateways = Gateway::where('status',1)->get();
        $tax      = get_option('tax');
        $tax      = $tax > 0 ? ($plan->price / 100) * $tax : 0;
        $total    = (double)$tax+$plan->price;
        $invoice_data = get_option('invoice_data',true); 

        Session::forget('payment_info');
        Session::forget('call_back');
        Session::forget('plan_id');

        return view('user.subscription.payment',compact('plan','gateways','tax','total','invoice_data'));
    }

    public function log()
    {
        $orders = Order::where('user_id',Auth::id())->with('plan','gateway')->latest()->paginate(20);

        return view('user.subscription.log',compact('orders'));
    }

    /**
     * store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request, $gatewayid,$planid)
    {

      $plan     = Plan::where('status',1)->where('price','>',0)->findorFail($planid);

      $gateway  = Gateway::where('status',1)->findorFail($gatewayid);
      $tax      = get_option('tax');
      $tax      = $tax > 0 ? ($plan->price / 100) * $tax : 0;
      $total    = (double)$tax+$plan->price;
      $payable  = $total*$gateway->multiply+$gateway->charge;

        if ($gateway->min_amount > $payable ){
            return redirect()->back()->with('min-max', __('The minimum transaction amount is :amount '.$gateway->min_amount));
        }
        if ($gateway->max_amount != -1) {
            if($gateway->max_amount < $payable){
                return redirect()->back()->with('min-max', __('The maximum transaction amount is :amount '.$gateway->max_amount));
            }
        }
        
      

      if ($gateway->is_auto == 0) {

        $request->validate([
            'comment' => ['required', 'string', 'max:500'],
            'image' => ['required', 'image', 'max:2048'], // 2MB
        ]);

        $payment_data['comment'] = $request->input('comment');
        if ($request->hasFile('image')) {
            $path = 'uploads' . '/payments' . date('/y/m/');
            $name = uniqid().".".$request->file('image')->extension();
            Storage::put($path . $name, file_get_contents(Request()->file('image')));
            ;
            $payment_data['screenshot'] = Storage::url($path . $name);
        }
       }

      Session::put('plan_id',$plan->id);

      $payment_data['currency']   = $gateway->currency ?? 'USD';
      $payment_data['email']      = Auth::user()->email;
      $payment_data['name']       = Auth::user()->name;
      $payment_data['phone']      = $request->phone;
      $payment_data['billName']   = 'Plan Name: '.$plan->title;
      $payment_data['amount']     = $total;
      $payment_data['test_mode']  = $gateway->test_mode;
      $payment_data['charge']     = $gateway->charge ?? 0;
      $payment_data['pay_amount'] =  str_replace(',','',number_format($payable));
      $payment_data['getway_id']  = $gateway->id;
       
      $callback['success'] = url('user/subscription/plan/success');
      $callback['fail']    = url('user/subscription/plan/failed');
      Session::put('call_back',$callback);


        if (!empty($gateway->data)) {
            foreach (json_decode($gateway->data ?? '') ?? [] as $key => $info) {
                $payment_data[$key] = $info;
            };
        }
       
        return $gateway->namespace::make_payment($payment_data);
      

    }

    public function status($status)
    {
       abort_if(!Session::has('call_back') || !Session::has('plan_id'),404); 
     
       return $status == 'success' ? $this->success() : $this->faild();
    }

    public function success()
    {
        abort_if(!Session::has('payment_info'),404);

        $paymentInfo = Session::get('payment_info');

        Session::forget('payment_info');
        Session::forget('call_back');
        

        $plan     = Plan::where('status',1)->where('price','>',0)->findorFail(Session::get('plan_id'));
        Session::forget('plan_id');
        
        $redirectUrl = auth()->user()->will_expire == null ? '/user/device/create' : '/user/dashboard';
        
        auth()->user()->will_expire == null ? Session::put('new-user',__('Lets create a whatsapp device')) : null;
        
        
        if ($paymentInfo['status'] == 1) {
            $user = auth()->user();
            $user->plan = json_encode($plan->data);
            $user->plan_id = $plan->id;
            $user->will_expire = now()->addDays($plan->days);
            $user->save();
        }
        

        $tax      = get_option('tax');
        $tax      = $tax > 0 ? ($plan->price / 100) * $tax : 0;

        $order = new Order;
        $order->plan_id     = $plan->id;
        $order->payment_id  = $paymentInfo['payment_id'];
        $order->user_id     = Auth::id();
        $order->gateway_id  = $paymentInfo['getway_id'];
        $order->amount      = $paymentInfo['amount'];
        $order->tax         = $tax;
        $order->status      = $paymentInfo['status'] ?? 1;
        $order->will_expire = now()->addDays($plan->days);
        if (isset($paymentInfo['meta'])) {
            $order->meta    = json_encode($paymentInfo['meta']);
        }
        $order->save();

        $this->sentOrderMail($order);

        $message = $paymentInfo['status'] == 1 ? __('Your subscription payment is complete') : __('Your subscription payment is complete admin will review this payment manually for approval.');

        Session::flash('success',$message);

        if ($paymentInfo['status'] == 1) {
            return redirect($redirectUrl);
        }

        return redirect('user/dashboard');

    }

    public function faild()
    {
        $plan_id = Session::get('plan_id');

        Session::forget('payment_info');
        Session::forget('call_back');
        Session::forget('plan_id');

        Session::flash('error',true);

        return redirect('/user/subscription/'.$plan_id);
    }


}
