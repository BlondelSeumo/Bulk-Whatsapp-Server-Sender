<?php
namespace App\Gateway;
use Omnipay\Omnipay;
use Session;
use Illuminate\Http\Request;

class Stripe {
    
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

        if(Session::has('stripe_credentials')){
           $Info=Session::get('stripe_credentials');
           
           return view('gateways.stripe',compact('Info'));
        }
        abort(404);
    }

    public static function fallback()
    {
       return url('/payment/stripe'); 
    }

    public static function make_payment($array)
    {
        
        $publishable_key=$array['publishable_key'];
        $secret_key=$array['secret_key'];
        $currency=$array['currency'];
        $email=$array['email'];
        $amount=$array['amount'];
        $totalAmount=$array['pay_amount'];
        $name=$array['name'];
        $billName=$array['billName'];
        $test_mode=$array['test_mode'];
        $data['publishable_key']=$publishable_key;
        $data['secret_key']=$secret_key;
        $data['payment_mode']='stripe';
        $data['amount']=$totalAmount;
        $data['test_mode']=$test_mode;
       
        $data['charge']=$array['charge'];
        $data['main_amount']=$array['amount'];
        $data['getway_id']=$array['getway_id'];
        $data['is_fallback']=$array['is_fallback'] ?? 0;
        $data['payment_type']=$array['payment_type'] ?? '';
        $data['currency']=$array['currency'];
        

        Session::put('stripe_credentials',$data);

        
        return redirect()->route('stripe.view');
    }

    public function status(Request $request)
    {
        abort_if(!Session::has('stripe_credentials'), 404);
        $credentials=Session::get('stripe_credentials');
        
        $stripe = Omnipay::create('Stripe');
        $token = $request->stripeToken;
        $gateway = $credentials['publishable_key'];
        $secret_key = $credentials['secret_key'];
        $main_amount = $credentials['amount']; 
        
        $stripe->setApiKey($secret_key);

        if($token){
            $response = $stripe->purchase([
                'amount' => $main_amount,
                'currency' => $credentials['currency'],
                'token' => $token,
            ])->send();
        }
       

        if ($response->isSuccessful()) {
            $arr_body = $response->getData();
            $data['payment_id'] = $arr_body['id'];
            $data['payment_method'] = "stripe";
            $data['getway_id'] = $credentials['getway_id'];
            $data['payment_type'] = $credentials['payment_type'];
           
            $data['amount'] = $credentials['main_amount'];
            $data['charge'] = $credentials['charge'];
            $data['status'] = 1;          
            $data['payment_status'] = 1;   
            $data['is_fallback'] = $credentials['is_fallback'];
            Session::put('payment_info',$data);
            Session::forget('stripe_credentials');
            return redirect(Stripe::redirect_if_payment_success());
        }
        else{
            $data['payment_status'] = 0;  
            Session::put('payment_info',$data); 
           Session::forget('stripe_credentials');
           return redirect(Stripe::redirect_if_payment_faild());
        }
    }
    public static function isfraud($creds){
        $payment_id = $creds['payment_id'];
        $secret_key = $creds['secret_key'];

        try {
        $stripe = new \Stripe\StripeClient($secret_key);

        $response = $stripe->charges->retrieve(
            $payment_id,
            [],
        );
        return $response->status === "succeeded" ? 1 : 0;
        } catch (\Throwable $th) {
            return 0;
        }
         
    }

}


?>