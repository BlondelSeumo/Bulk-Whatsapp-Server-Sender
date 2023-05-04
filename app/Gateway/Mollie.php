<?php
namespace App\Gateway;
use Session;
use Illuminate\Http\Request;
class Mollie {
        
    public static function redirect_if_payment_success()
    {
        if(Session::has('call_back')){
            return url(Session::get('call_back')['success']);
        }
    }

    public static function redirect_if_payment_faild()
    {
        if(Session::has('call_back')){
            return url(Session::get('call_back')['fail']);
        }
    }

    public static function fallback()
    {
        return url('/payment/mollie');
    }

    public static function make_payment($array){
      
     
        $total_amount=str_replace(',','',number_format($array['pay_amount'],2));
        $currency=$array['currency'];
        $email=$array['email'];
        $amount=$total_amount;
        $name=$array['name'];
        $billName=$array['billName'];
        $test_mode=$array['test_mode'];
        $data['api_key']=$array['api_key'];
        $data['payment_mode']='mollie';
        $data['amount']=$amount;
        $data['is_fallback']=$array['is_fallback'] ?? 0;
        $data['charge']=$array['charge'];
        $data['main_amount']=$array['amount'];
        $data['getway_id']=$array['getway_id'];
        $data['payment_type']=$array['payment_type'] ?? '';
        $data['test_mode']=$test_mode;
        
     

        if($test_mode == 0){
            $data['env']=false;
            $test_mode=false;
        }
        else{
            $data['env']=true;
            $test_mode=true;
        }
        Session::put('mollie_credentials',$data);
        try {
            $mollie = new \Mollie\Api\MollieApiClient();
            $mollie->setApiKey($array['api_key']);
            $payment = $mollie->payments->create([
                "amount" => [
                    "currency" => strtoupper($currency),
                    "value" => $amount
                ],
                "description" => $billName,
                "redirectUrl" => Mollie::fallback(),
            ]);
            
            Session::put('pay_id',$payment->id);
            
            return redirect($payment->getCheckoutUrl()) ;
        }
        catch (\Exception $e) {
            return redirect(Mollie::redirect_if_payment_faild());  
        }
        
    }

    public function status(Request $request){
       
        if(Session::has('pay_id') && Session::has('mollie_credentials')){
              $info=Session::get('mollie_credentials');
             
        
              $mollie = new \Mollie\Api\MollieApiClient();
              $mollie->setApiKey($info['api_key']);
              $pay_id= Session::get('pay_id');
              $payment = $mollie->payments->get($pay_id);

              if ($payment->isPaid())
              {
                $data['payment_id'] =  Session::get('pay_id');
                $data['payment_method'] = "mollie";
                $data['getway_id'] = $info['getway_id'];
                $data['payment_type'] = $info['payment_type'];
                $data['amount'] = $info['main_amount'];
                $data['charge'] = $info['charge'];
                $data['status'] = 1;  
                $data['payment_status'] = 1;   
                $data['is_fallback'] = $info['is_fallback'];
                
                Session::forget('pay_id');
                Session::forget('mollie_credentials');
                Session::put('payment_info',$data);
                return redirect(Mollie::redirect_if_payment_success());
              }
             
             
              Session::forget('pay_id');
              Session::forget('mollie_credentials');
              return redirect(Mollie::redirect_if_payment_faild());  
        }
        abort(404);
        
    }

   


}    