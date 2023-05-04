<?php
namespace App\Gateway;

use App\Models\Getway;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Http;
use Str;
class Paystack {

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
       return url('/payment/paystack');
    }

    public function view(){

        if(Session::has('paystack_credentials')){
            $Info=Session::get('paystack_credentials');
           
           return view('gateways.paystack',compact('Info'));
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


        $data['public_key']=$array['public_key'];
        $data['secret_key']=$array['secret_key'];
        $data['payment_mode']='paystack';
        $data['amount']=$amount;
        $data['charge']=$array['charge'];
        $data['phone']=$array['phone'];
        $test_mode=$array['test_mode'];
        
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


        Session::put('paystack_credentials',$data);

        return redirect()->route('paystack.view');

    }


    public function status(Request $request)
    {
        if(!Session::has('paystack_credentials')){
            return abort(404);
        }


        $info=Session::get('paystack_credentials');
        $curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$request->ref_id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer ".$info['secret_key']."",
				"Cache-Control: no-cache",
			),
		));

        $response = curl_exec($curl);

		$err = curl_error($curl);
        curl_close($curl);
        

		if ($err) {
             Session::forget('paystack_credentials');
             $data['payment_status'] = 0;  
             Session::put('payment_info',$data); 
			 return redirect(Paystack::redirect_if_payment_faild());
		} else {
			$data=json_decode($response);
			if($data->status == true && $data->data->status == 'success'){
				$ref_id=$data->data->reference;
				$amount=$data->data->amount/100;
				if($amount != $info['amount']){
                    return abort(404);
                }

				$pay_data['payment_id'] = $ref_id;
				$pay_data['payment_method'] = "paystack";
                $pay_data['getway_id'] = $info['getway_id'];
                $pay_data['amount'] = $info['main_amount'];
                $pay_data['charge'] = $info['charge'];
                $pay_data['status'] = 1;
                $pay_data['payment_status'] = 1;
                $pay_data['is_fallback'] = $info['is_fallback'];

                

                Session::forget('paystack_credentials');
                Session::put('payment_info',$pay_data);

				return redirect(Paystack::redirect_if_payment_success());
			}
		}
        Session::forget('paystack_credentials');
        return redirect(Paystack::redirect_if_payment_faild());

    }


    public static function isfraud($cred){
        $secret_key = $cred['secret_key'];
        $reference = $cred['payment_id'];
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$reference,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ". $secret_key,
            "Cache-Control: no-cache",
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $arr = json_decode($response, true);
        if (array_key_exists('data', $arr)) {
            return $arr['data']['status'] === "success" ? 1 : 0;
        }
        } catch (\Throwable $th) {
            return 0;
        }

    }
}


?>
