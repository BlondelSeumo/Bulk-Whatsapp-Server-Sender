<?php
namespace App\Gateway;

use App\Models\Order;
use Session;
use Illuminate\Http\Request;
use Http;
use Str;
class CustomGateway {
        
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

   

    public static function make_payment($array)
    {
        $currency=$array['currency'];
        $email=$array['email'];
        $amount=$array['pay_amount'];
        $name=$array['name'];
        $billName=$array['billName'];

        $data['payment_mode']='manual';
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
        $data['screenshot']=$array['screenshot'] ?? '';
        $data['comment']=$array['comment'] ?? '';
        if($test_mode == 0){
            $data['env']=false;
            $test_mode=false;
        }
        else{
            $data['env']=true;
            $test_mode=true;
        }



        Session::put('manual_credentials',$data);

        return redirect('/manual/payment');
    
    }


    public function status()
    {
       
        if(!Session::has('manual_credentials')){
            return abort(404);
        }
        $info=Session::get('manual_credentials');
        
        $data['payment_id'] = $this->generateString();           
        $data['payment_method'] = "manual";
        $data['getway_id'] = $info['getway_id'];

        $data['amount'] = $info['main_amount'];
        $data['charge'] = $info['charge'];
        $data['status'] = 2;   
        $data['payment_status'] = 2;  

        $data['meta']=array('screenshot'=>$info['screenshot'] ?? '','comment'=>$info['comment'] ?? '');


        Session::forget('manual_credentials');
        Session::put('payment_info',$data); 
        return redirect(CustomGateway::redirect_if_payment_success());
      
    }


    public function generateString()
    {
       return Str::random(15).rand(100,200);
       
    }

}


?>
