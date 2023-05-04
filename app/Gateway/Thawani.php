<?php

namespace App\Gateway;

use App\Models\Paymentmeta;
use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;
use Http;
use Str;

class Thawani
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

    public static function fallback()
    {
        return url('payment/thawani');
    }

    public static function make_payment($array)
    {
        $currency = $array['currency'];
        $email = $array['email'];
        $amount = $array['pay_amount'];
        $name = $array['name'];
        $billName = $array['billName'];
        $data['secret_key'] = $array['secret_key'];
        $data['public_key'] = $array['publishable_key'];
        $data['payment_mode'] = 'thawani';
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
      
        $productJson = json_encode([
            'name' => $billName,
            'unit_amount' => (float) ceil($array['pay_amount'] * 1000),
            'quantity' => 1,
        ]);

        if ($test_mode == 0) {
            $data['env'] = false;
            $test_mode = false;
        } else {
            $data['env'] = true;
            $test_mode = true;
        }
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://uatcheckout.thawani.om/api/v1/checkout/session",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "thawani-api-key: " . $data['secret_key']
            ],
            CURLOPT_POSTFIELDS => '{"client_reference_id": '.strtotime(Carbon::now()).',
            "products": [' . $productJson . '],
            "success_url": "' . Thawani::fallback() . '",
            "cancel_url": "' . Thawani::redirect_if_payment_faild() . '"}',
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        $response = json_decode($response, true);

        if (array_key_exists('success', $response) && $response['success'] == true) {
            $session_id = $response['data']['session_id'];
            $data['response'] = $response;
            if ($test_mode == true) {
                $url = "https://uatcheckout.thawani.om/pay/" . $session_id . "?key=" . $array['publishable_key'];
            } else {
                $url = "https://checkout.thawani.om/pay/" . $session_id . "?key=" . $array['publishable_key'];
            }
            Session::put('thawani_credentials', $data);
        }else{
            Session::has('thawani_credentials') ? Session::forget('thawani_credentials') : '';
            $url = Thawani::redirect_if_payment_faild();
        }

        Session::put('thawani_credentials', $data);
        return redirect($url);
    }


    public function status(Request $request)
    {
        if (!Session::has('thawani_credentials')) {
            return abort(404);
        }
        $info = Session::get('thawani_credentials');
        $test_mode = Session::get('thawani_credentials')['test_mode'];
        $secret_key = Session::get('thawani_credentials')['secret_key'];
        $invoice = Session::get('thawani_credentials')['response']['data']['invoice'];
        $response = $this->getResponse($test_mode,$invoice, $secret_key);
        $responseArr = json_decode($response, true);
        
        if (array_key_exists('success', $responseArr) && $responseArr['success'] == true) {
            $data['payment_id'] = $responseArr['data'][0]['payment_id'];
            $data['payment_method'] = "thawani";
            $data['getway_id'] = $info['getway_id'];
            
            $data['amount'] = $info['main_amount'];
            $data['charge'] = $info['charge'];
            $data['status'] = 1;
            $data['payment_status'] = 1;
           

            
            Session::forget('thawani_credentials');
            Session::put('payment_info', $data);
            return redirect(thawani::redirect_if_payment_success());
        } else {
            $data['payment_status'] = 0;  
            Session::put('payment_info',$data); 
            Session::forget('thawani_credentials');
            return redirect(thawani::redirect_if_payment_faild());
        }
    }

    private function getResponse($test_mode, $invoice_id, $api_key){
        if ($test_mode == 1) {
            $url = "https://uatcheckout.thawani.om/api/v1/payments/?checkout_invoice=$invoice_id";
        }else{
            $url = "https://checkout.thawani.om/api/v1/payments/?checkout_invoice=$invoice_id";
        }
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "",
          CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "thawani-api-key: ".$api_key
          ],
        ]);  
        
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        
        if ($err) {
          return $err;
        } else {
          return $response;
        }
    }



    public static function isfraud($creds){
        $invoice_id = $creds['payment_id'];
        $api_key = $creds['secret_key'];
        $test_mode = $creds['is_test'];

        if ($test_mode == 1) {
            $url = "https://uatcheckout.thawani.om/api/v1/payments/?checkout_invoice=$invoice_id";
        }else{
            $url = "https://checkout.thawani.om/api/v1/payments/?checkout_invoice=$invoice_id";
        }

        try {
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "",
          CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "thawani-api-key: ".$api_key
          ],
        ]);  
        
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        
        $arr = json_decode($response, true);
        if (array_key_exists('success', $arr) && $arr['success'] == true) {
            return 1;
        }else{
            return 0;
        }
                 
        } catch (\Throwable $th) {
            return 0;
        }
        
    }
}
