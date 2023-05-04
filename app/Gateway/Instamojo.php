<?php
namespace App\Gateway;
use Session;
use Illuminate\Http\Request;
use Http;
class Instamojo {
        
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
         return url('payment/instamojo');
    }

    public static function make_payment($array)
    {
        $regex = "/^(0|91|\+91)?[789]\d{9}$/";
        if ($array['phone'] == "") {
            return redirect()->back()->with('min-max',__('Phone Number not given!'));
        }
        if (!preg_match($regex, $array['phone'])) {
            return redirect()->back()->with('min-max',__('The phone number should be indian!'));
        }

        $currency=$array['currency'];
        $email=$array['email'];
        $amount=$array['pay_amount'];
        $name=$array['name'];
        $billName=$array['billName'];


        $test_mode=$array['test_mode'];
       
        $data['test_mode']=$test_mode;
        
        $data['x_auth_token']=$array['x_auth_token'];
        $data['x_api_key']=$array['x_api_key'];
        $data['payment_mode']='instamojo';
        $data['amount']=$amount;
        $data['charge']=$array['charge'];
        $data['phone']=$array['phone'];
        $data['getway_id']=$array['getway_id'];
        $data['main_amount']=$array['amount'];
       
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
        Session::put('instamojo_credentials',$data);


        if ($test_mode == true) {
            $url='https://test.instamojo.com/api/1.1/payment-requests/';
        }
        else{
            $url='https://www.instamojo.com/api/1.1/payment-requests/';
        }     

        try {
            $params=[
                'purpose' => $data['billName'],
                'amount' => $amount,
                'phone' => $data['phone'],
                'buyer_name' => $name,
                'redirect_url' => Instamojo::fallback(),
                'send_email' => true,
                'send_sms' => true,
                'email' => $email,
                'allow_repeated_payments' => false
            ];
         $response=Http::asForm()->withHeaders([
                'X-Api-Key' => $data['x_api_key'],
                'X-Auth-Token' => $data['x_auth_token']
            ])->post($url,$params);
         
        if(isset($response['payment_request'])) {
            $url= $response['payment_request']['longurl'];
            return redirect($url);
        }
       else{
            Session::forget('instamojo_credentials');
            return redirect(Instamojo::redirect_if_payment_faild());
        }
        } catch (\Throwable $th) {
            Session::forget('instamojo_credentials');
            return redirect(Instamojo::redirect_if_payment_faild());
        }
       
        
    }


    public function status()
    {
        if(!Session::has('instamojo_credentials')){
            return abort(404);
        }
        $response=Request()->all();
        $payment_id=$response['payment_id'];
        $info=Session::get('instamojo_credentials');
       
        if ($response['payment_status']=='Credit') {
             $data['payment_id'] = $payment_id;           
             $data['payment_method'] = "instamojo";
             $data['getway_id'] = $info['getway_id'];
           
             $data['amount'] = $info['main_amount'];
             $data['charge'] = $info['charge'];
             $data['status'] = 1;  
             $data['payment_status'] = 1;   
             
             Session::forget('instamojo_credentials');
             Session::put('payment_info',$data); 
             
             return redirect(Instamojo::redirect_if_payment_success());
        }      
        else{
            $data['payment_status'] = 0;  
            Session::put('payment_info',$data); 
            Session::forget('instamojo_credentials');
            return redirect(Instamojo::redirect_if_payment_faild());
        }
    }

    public static function isfraud($creds){
        $payment_id = $creds['payment_id'];
        $api = $creds['x_api_key'];
        $is_test = $creds['is_test'];
        $auth_token = $creds['x_auth_token'];

        if ($is_test == 1) {
            $url = 'https://test.instamojo.com/api/1.1/payments/'.$payment_id.'/';
        }else{
            $url = 'https://www.instamojo.com/api/1.1/payments/'.$payment_id.'/';
        }
        
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                        array(
                            "Content-Type: application/json",
                            "X-Api-Key:".$api,
                            "X-Auth-Token:".$auth_token));
            $response = curl_exec($ch);
            curl_close($ch); 
            $arr = json_decode($response, true);
            return $arr['success'] === true ? 1 : 0;
        } catch (\Throwable $th) {
           return 0;
        }

        
    }

}
