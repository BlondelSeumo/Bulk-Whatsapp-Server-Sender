<?php
namespace App\Gateway;
use Session;
use Illuminate\Http\Request;
use Http;
use Str;
class Flutterwave {
        
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
        return url('payment/flutterwave');
    }

    public static function make_payment($array)
    {
        $currency=$array['currency'];
        $email=$array['email'];
        $amount=$array['pay_amount'];
        $name=$array['name'];
        $billName=$array['billName'];
        
        $data['secret_key']=$array['secret_key'];
        $data['public_key']=$array['public_key'];
        $data['payment_options']=$array['payment_options'];
        $data['encryption_key']=$array['encryption_key'];
        $data['payment_mode']='flutterwave';
        $test_mode=$array['test_mode'];
        $data['test_mode']=$test_mode;
        
        $data['amount']=$amount;
        $data['charge']=$array['charge'];
        $data['phone']=$array['phone'];
        $data['getway_id']=$array['getway_id'];
        $data['main_amount']=$array['amount'];
      
        $data['billName']=$billName;
        $data['name']=$name;
        $data['email']=$email;
        $data['currency']=$currency;
        $data['is_fallback']=$array['is_fallback'] ?? 0;
        
        if($test_mode == 0){
            $data['env']=false;
            $test_mode=false;
        }
        else{
            $data['env']=true;
            $test_mode=true;
        }

        Session::put('flutterwave_credentials',$data);

        if ($test_mode == true) {
            $url='https://api.flutterwave.com/v3/payments';
        }
        else{
            $url='https://api.flutterwave.com/v3/payments';
        }

        $logo=  get_option('primary_data',true)->logo ?? '';

        try {
            $params=[
                "tx_ref" => Str::random(10),
                "currency" => $data['currency'],
                "amount" => $amount,
                "payment_options"=> $data['payment_options'],
                "redirect_url" => Flutterwave::fallback(),
                 "customer" => [
                    "email"=>$data['email'],
                    "phonenumber"=> $data['phone'],
                    "name"=> $data['name']
                 ],
                 "customizations"=>[
                    "title"=> $data['billName'],
                    "description"=> "",
                    "logo"=> $logo
                 ]   
            ];

           $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$data['secret_key'],
            ])->post($url, $params);
           
        if(isset($response['status']) && $response['status'] == 'success') {
            $url= $response['data']['link'];
            return redirect($url);
        }
       else{
            Session::forget('flutterwave_credentials');
            return redirect(Flutterwave::redirect_if_payment_faild());
        }
        } catch (\Throwable $th) {
            Session::forget('flutterwave_credentials');
            return redirect(Flutterwave::redirect_if_payment_faild());
        }
    }


    public function status()
    {
        if(!Session::has('flutterwave_credentials')){
            return abort(404);
        }
        $response=Request()->all();
        $payment_id=$response['transaction_id'] ?? $response['tx_ref'];
        $info=Session::get('flutterwave_credentials');
        $cred['secret_key']=$info['secret_key'];
        $cred['payment_id']=$payment_id;

        $status=Flutterwave::isfraud($cred);
        if ($status == 1) {


             $data['payment_id'] = $payment_id;           
             $data['payment_method'] = "flutterwave";
             $data['getway_id'] = $info['getway_id'];
            
             $data['amount'] = $info['main_amount'];
             $data['charge'] = $info['charge'];
             $data['status'] = 1;   
             $data['payment_status'] = 1;  
            
               
             Session::forget('flutterwave_credentials');
             Session::put('payment_info',$data); 
             return redirect(Flutterwave::redirect_if_payment_success());
        }      
        else{
            $data['payment_status'] = 0;  
            Session::put('payment_info',$data); 
            Session::forget('flutterwave_credentials');
            return redirect(Flutterwave::redirect_if_payment_faild());
        }
    }


    public static function isfraud($cred){
        $secret_key = $cred['secret_key'];
        $payment_id = $cred['payment_id'];
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/".$payment_id."/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ". $secret_key
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $arr = json_decode($response, true);
            return $arr['status'] === "success" ? 1 : 0;
        } catch (\Throwable $th) {
            return  0;
        }
    }
}


?>
