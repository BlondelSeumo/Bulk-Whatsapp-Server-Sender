<?php
namespace App\Gateway;
use Illuminate\Support\Facades\Session;


class Payu {
        
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
       return route('payu.status'); 
    }

    public function view()
    {
        if(Session::has('payu_credentials')){
            $Info=Session::get('payu_credentials');
           
            return view('gateways.payu',compact('Info'));
        }
        abort(404);
    }

    public static function make_payment($array)
    {
        $currency=$array['currency'];
        $email=$array['email'];
        $amount=$array['pay_amount'];
        $name=$array['name'];
        $data['txnid'] = $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $billName=$array['billName'];
        $data['merchant_key']=$array['merchant_key'];
        $data['hash']=$array['merchant_salt'];
        $data['payment_mode']='payu';
        $data['amount']=$amount;
        $data['charge']=$array['charge'];
        $data['phone']=$array['phone'];
        $data['getway_id']=$array['getway_id'];
        $data['main_amount']=$array['amount'];
        $data['billName']=$billName;
        $data['name']=$name;
        $data['email']=$email;
        $data['currency']=$currency;
       
        $test_mode=$array['test_mode'];
        $data['test_mode']=$test_mode;
       
        
     
        if($test_mode == 0){
            $data['env']=false;
            $test_mode=false;
        }
        else{
            $data['env']=true;
            $test_mode=true;
        }

        if ($test_mode == false) {
			$url='https://secure.payu.in/_payment';
		}
		else{
			$url='https://sandboxsecure.payu.in/_payment';
		}

		$info = array(
			'key'=> $array['merchant_key'],
			'test_mode '=> $test_mode,
			'txnid' => $txnid,
			'amount'=>  $amount,
			'firstname'=> $name,
			'lastname'=> "",
			'email'=>$email,
			'salt'=> $array['merchant_salt'],
			'productinfo'=>$billName,
			'phone'=> $array['phone'],
			'service_provider'=> 'payu_paisa',
			'surl'=> Payu::fallback(),
			'udf5'=> 'BOLT_KIT_PHP7',
			'furl'=> Payu::redirect_if_payment_faild(),
		);  

        $hash=hash('sha512', $info['key'].'|'.$info['txnid'].'|'.$info['amount'].'|'.$info['productinfo'].'|'.$info['firstname'].'|'.$info['email'].'|||||'.$info['udf5'].'||||||'.$info['salt']);

    	$info['hash'] = $hash;

      

       $data = array_merge($data,$info);
       Session::put('payu_credentials',$data);

        if ($data) {
            return redirect()->route('payu.view');
        }	
        
    }



    public function status()
    {
        if(!Session::has('payu_credentials')){
            return abort(404);
        }
        $info=Session::get('payu_credentials');
        
        if (Request()->status == 'success') {
             $data['payment_id'] = Request()->payuMoneyId;           
             $data['payment_method'] = "payu";
             $data['getway_id'] = $info['getway_id'];
            
             $data['amount'] = $info['amount'];
             $data['charge'] = $info['charge'];
             $data['status'] = 1;  
             $data['payment_status'] = 1; 
             
             
             Session::forget('payu_credentials');
             Session::put('payment_info',$data); 
            return redirect(Payu::redirect_if_payment_success());
        }      
        else{
            $data['payment_status'] = 0;  
            Session::put('payment_info',$data); 
            Session::forget('payu_credentials');
            return redirect(Payu::redirect_if_payment_faild());
        }
    }

}

