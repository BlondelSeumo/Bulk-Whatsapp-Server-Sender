<?php
namespace App\Gateway;
use Omnipay\Omnipay;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use App\Models\Gateway;
class Razorpay {

    protected static $payment_id;

    public static function redirect_if_payment_success(){
        if(Session::has('call_back')){
            return url(Session::get('call_back')['success']);
        }
    }

    public static function redirect_if_payment_faild(){
        if(Session::has('call_back')){
            return url(Session::get('call_back')['fail']);
        }
    }

    public function view(){
        if(Session::has('razorpay_credentials')){
            $Info=Session::get('razorpay_credentials');
            $gateway = Gateway::where('status',1)->findOrFail($Info['getway_id']);
            $response=Session::get('razorpay_response');
            
            return view('gateways.razorpay',compact('response','Info','gateway'));
        }
        abort(404);
    }



    public static function make_payment($array)
    {
        $currency=$array['currency'];
       
        $email=$array['email'];
        $amount=$array['pay_amount'];
        $name=$array['name'];
        $billName=$array['billName'];
        $data['key_id']=$array['key_id'];
        $data['key_secret']=$array['key_secret'];
        $data['payment_mode']='razorpay';
        $data['amount']=$amount;
        $data['charge']=$array['charge'];
        $data['phone']=$array['phone'];
        $data['getway_id']=$array['getway_id'];
        $data['is_fallback']=$array['is_fallback'] ?? 0;
        $data['main_amount']=$array['amount'];
        $test_mode=$array['test_mode'];
        $data['test_mode']=$test_mode;
        
       
        $data['billName']=$billName;
        $data['name']=$name;
        $data['email']=$email;
        $data['currency']=$currency;
       
        
     
        if($test_mode == 0){
            $data['env']=false;
            $test_mode=false;
        }
        else{
            $data['env']=true;
            $test_mode=true;
        }


        Session::put('razorpay_credentials',$data);

        $response=Razorpay::get_response();

        Session::put('razorpay_response',$response);
       
        return redirect()->route('razorpay.view');

    }

    public static function get_response(){
        $array=Session::get('razorpay_credentials');
        $amount=$array['amount'];

        $phone=$array['phone'];
        $email=$array['email'];
        $amount=$array['amount'];
        $getway_id=$array['getway_id'];
        $name=$array['name'];
        $billName=$array['billName'];

        $razorpay_credentials=Session::get('razorpay_credentials');


        $api = new Api($razorpay_credentials['key_id'], $razorpay_credentials['key_secret']);
        $referance_id=Str::random(12);
        $order = $api->order->create(array(
            'receipt' => $referance_id,
            'amount' => $amount*100,
            'currency' => $razorpay_credentials['currency'],
        )
        );

         // Return response on payment page
        $response = [
            'orderId' => $order['id'],
            'razorpayId' => $razorpay_credentials['key_id'],
            'amount' => $amount*100,
            'name' => $name,
            'currency' => $razorpay_credentials['currency'],
            'email' => $email,
            'contactNumber' => $phone,
            'address' => "",
            'description' => $billName,
        ];

        return $response;
    }


    public function status(Request $request)
    {
      if(Session::has('razorpay_credentials')){
        $order_info= Session::get('razorpay_credentials');
       
        // Now verify the signature is correct . We create the private function for verify the signature
        $signatureStatus = Razorpay::SignatureVerify(
            $request->all()['rzp_signature'],
            $request->all()['rzp_paymentid'],
            $request->all()['rzp_orderid']
        );

      // If Signature status is true We will save the payment response in our database
      // In this tutorial we send the response to Success page if payment successfully made
        if($signatureStatus == true)
        {
            //for success
            $data['payment_id'] = Razorpay::$payment_id;
            $data['payment_method'] = "razorpay";
            $data['getway_id']=$order_info['getway_id'];
            $data['amount'] =$order_info['amount'];
            $data['billName']=$order_info['billName'];
            $data['getway_id'] = $order_info['getway_id'];
            
            $data['amount'] = $order_info['main_amount'];
            $data['charge'] = $order_info['charge'];
            $data['status'] = 1;
            $data['payment_status'] = 1; 
            $data['is_fallback'] = $order_info['is_fallback'];
            
            Session::put('payment_info',$data);
            Session::forget('razorpay_credentials');
            return redirect(Razorpay::redirect_if_payment_success());
        }
        else{
            $data['payment_status'] = 0;  
            Session::put('payment_info',$data); 
            Session::forget('razorpay_credentials');
            return redirect(Razorpay::redirect_if_payment_faild());
        }

      }
    }

    // In this function we return boolean if signature is correct
    private static function SignatureVerify($_signature,$_paymentId,$_orderId)
    {
        try
        {
            $razorpay_credentials=Session::get('razorpay_credentials');
            // Create an object of razorpay class
            $api = new Api($razorpay_credentials['key_id'], $razorpay_credentials['key_secret']);
            $attributes  = array('razorpay_signature'  => $_signature,  'razorpay_payment_id'  => $_paymentId ,  'razorpay_order_id' => $_orderId);
            $order  = $api->utility->verifyPaymentSignature($attributes);
            Razorpay::$payment_id=$_paymentId;
            return true;
        }
        catch(\Exception $e)
        {
            // If Signature is not correct its give a excetption so we use try catch
            return false;
        }
    }

    public static function isfraud($creds){
        $payment_id = $creds['payment_id'];
        $key = $creds['key_id'];
        $secret = $creds['key_secret'];
        try {
            $api = new Api($key, $secret);
            $payment = $api->payment->fetch($payment_id);
            if ($payment) {
               return $payment['status'] === "captured" ? 1 : 0;
            }
        } catch (\Throwable $th) {
            return 0;
        }
        
    }


}


?>
