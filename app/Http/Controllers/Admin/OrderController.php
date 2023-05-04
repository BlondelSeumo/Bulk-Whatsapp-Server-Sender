<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Traits\Notifications;
use DB;
use Auth;
class OrderController extends Controller
{
    use Notifications;

    public function __construct()
    {
          $this->middleware('permission:order'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders= Order::query();

        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $orders = $orders->whereHas('user',function($q) use ($request){
                    return $q->where('email',$request->search);
                });
            }
            else{
                $orders = $orders->where($request->type,'LIKE','%'.$request->search.'%');
            }
           
        }

        $orders = $orders->with('user','plan','gateway')->latest()->paginate(20);

        $totalOrders= Order::count();
        $totalPendingOrders= Order::where('status',2)->count();
        $totalCompleteOrders= Order::where('status',1)->count();
        $totalDeclinedOrders= Order::where('status',0)->count();
        $type = $request->type ?? '';

        $invoice = get_option('invoice_data',true);
        $currency = get_option('base_currency',true);
        $tax = get_option('tax');

        return view('admin.orders.index',compact('orders','request','totalOrders','totalPendingOrders','totalCompleteOrders','totalDeclinedOrders','type','invoice','currency','tax'));
    }

  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order  = Order::with('user','plan','gateway')->findorFail($id);
        $invoice_data = get_option('invoice_data',true);

        return view('admin.orders.show',compact('order','invoice_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order  = Order::with('user','plan')->findorFail($id);
        $order->status = $request->status;
        $order->save();

        if ($request->assign_order == 'yes') {
            $order->user()->update([
                'plan_id'     => $order->plan_id,
                'will_expire' => $order->will_expire,
                'plan'        =>json_encode( $order->plan->data ?? ''),
            ]);
        }

        
        $status = $order->status == 2 ? 'pending' : ($order->status == 1 ? 'approved' : 'declined');
        $title = '('.$order->invoice_no.') Subscription order is '.$status;
        
        $notification['user_id'] = $order->user_id;
        $notification['title']   = $title;
        $notification['url'] = '/user/subscription-history';

        $this->createNotification($notification);

        return response()->json(['message' => __('Order status updated')],200);

    }
}
