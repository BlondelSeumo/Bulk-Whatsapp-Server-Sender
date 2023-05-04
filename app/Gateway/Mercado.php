<?php

namespace App\Gateway;

use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;
use Http;
use Str;
use MercadoPago;

class Mercado
{

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

    public static function fallback(){

         return url('payment/mercado');
    }


    public static function make_payment($array)
    {

        $currency = $array['currency'];
        $email = $array['email'];
        $amount = $array['pay_amount'];
        $name = $array['name'];
        $billName = $array['billName'];

        $data['secret_key'] = $array['secret_key'];
        $data['public_key'] = $array['public_key'];
        $data['payment_mode'] = 'mercadopago';
        $test_mode = $array['test_mode'];
        $data['test_mode'] = $test_mode;
       
        $data['amount'] = $amount;
        $data['charge'] = $array['charge'];
        $data['phone'] = $array['phone'];
        $data['getway_id'] = $array['getway_id'];
        $data['main_amount'] = $array['amount'];
        
        $data['billName'] = $billName;
        $data['name'] = $name;
        $data['email'] = $email;
        $data['currency'] = $currency;
       
       
        if ($test_mode == 0) {
            $data['env'] = false;
            $test_mode = false;
        } else {
            $data['env'] = true;
            $test_mode = true;
        }

        try {
            //Payment
            MercadoPago\SDK::setAccessToken($data['secret_key']);
            $payment = new MercadoPago\Payment();
            $preference = new MercadoPago\Preference();
            $payer = new MercadoPago\Payer();
            $payer->name = $name;
            $payer->email = $email;
            $payer->date_created = Carbon::now();

            
            $url = Mercado::fallback();
            
            
             
            $preference->back_urls = array(
                "success" => $url,
                "failure" => Mercado::redirect_if_payment_faild(),
                "pending" => $url,
            );

            $preference->auto_return = "approved";

            // Create a preference item
            $item = new MercadoPago\Item();
            $item->title = $billName;
            $item->quantity = 1;
            $item->unit_price = $amount;
            $preference->items = array($item);
            $preference->payer = $payer;
            $preference->save();


            $data['preference_id'] = $preference->id;
            $redirectUrl = $test_mode == 1 ? $preference->sandbox_init_point : $preference->init_point;
            
            Session::put('mercadopago_credentials', $data);
            
            return redirect($redirectUrl);

         } catch (\Throwable $th) {
            Mercado::redirect_if_payment_faild();
         }   
    }


    public function status()
    {
        if (!Session::has('mercadopago_credentials')) {
            return abort(404);
        }
    
        $response = Request()->all();

        $info = Session::get('mercadopago_credentials');

        

        if ($response['status'] == 'approved' || $response['status'] == 'pending') {
            $data['payment_id'] = $response['payment_id'];
            $data['payment_method'] = "mercadopago";
            $data['getway_id'] = $info['getway_id'];
           
            $data['amount'] = $info['main_amount'];
            $data['charge'] = $info['charge'];
            $data['status'] = $response['status'] == 'pending' ? 2 : 1;
            $data['payment_status'] = $response['status'] == 'pending' ? 2 : 1;
            

            Session::forget('mercadopago_credentials');
            Session::put('payment_info', $data);
            return redirect(Mercado::redirect_if_payment_success());
        }else{
            $data['payment_status'] = 0;  
            Session::put('payment_info',$data); 
            Session::forget('flutterwave_credentials');
            return redirect(Mercado::redirect_if_payment_faild());
        }
    }

}
