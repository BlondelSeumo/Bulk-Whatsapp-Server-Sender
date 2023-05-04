<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Smstransaction;
use App\Models\Smstesttransactions;
use App\Http\Requests\Bulkrequest;
use App\Models\User;
use App\Models\App;
use App\Models\Device;
use App\Models\Contact;
use App\Models\Template;
use App\Models\Reply;
use Carbon\Carbon;
use App\Traits\Whatsapp;
use Http;
use Auth;
use Str;
use DB;
use Session;
class BulkController extends Controller
{
    use Whatsapp;

    
    /**
     * sent message
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitRequest(Bulkrequest $request)
    {

        $user=User::where('status',1)->where('will_expire','>',now())->where('authkey',$request->authkey)->first();
        $app=App::where('key',$request->appkey)->whereHas('device')->with('device')->where('status',1)->first();

        if ($user == null || $app == null) {
            return response()->json(['error'=>'Invalid Auth and AppKey'],401);
        }

        if (getUserPlanData('messages_limit', $user->id) == false) {
            return response()->json([
                'message'=>__('Maximum Monthly Messages Limit Exceeded')
            ],401);  
        }

        if (!empty($request->template_id)) {

            $template = Template::where('user_id',$user->id)->where('uuid',$request->template_id)->where('status',1)->first();
            if (empty($template)) {
                return response()->json(['error'=>'Template Not Found'],401);
            }

            if (isset($template->body['text'])) {
                $body = $template->body;
                $text=$this->formatText($template->body['text'],[],$user);
                $text=$this->formatCustomText($text,$request->variables ?? []);
                $body['text'] = $text;
            }
            else{
                $body=$template->body;
            }
            $type = $template->type;

            
        }
        else{
            
            $text=$this->formatText($request->message);
            $body['text'] = $text;
            $type='plain-text';
        }

        if (!isset($body)) {
            return response()->json(['error'=>'Request Failed'],401);
        }    

        try {

            $response= $this->messageSend($body,$app->device_id,$request->to,$type,true,0);

            if ($response['status'] == 200) {
                
                $logs['user_id']=$user->id;
                $logs['device_id']=$app->device_id;
                $logs['app_id']=$app->id;
                $logs['from']=$app->device->phone ?? null;
                $logs['to']=$request->to;
                $logs['template_id']=$template->id ?? null;
                $logs['type']='from_api';

                $this->saveLog($logs);

                return response()->json(['message_status'=>'Success','data'=>[
                    'from'=>$app->device->phone ?? null,
                    'to'=>$request->to,                
                    'status_code'=>200,
                ]],200);
            }
            else{
                return response()->json(['error'=>'Request Failed'],401);

            }

        } catch (Exception $e) {

         return response()->json(['error'=>'Request Failed'],401);
     }

 }


 /**
  * set status device
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function setStatus($device_id,$status){

       $device_id=str_replace('device_','',$device_id);

       $device=Device::where('id',$device_id)->first();
       if (!empty($device)) {
          $device->status=$status;
          $device->save();
       }


  }


  /**
  * receive webhook response
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function webHook(Request $request,$device_id){
       
       $session=$device_id;
       $device_id=str_replace('device_','',$device_id);

       $device=Device::with('user')->whereHas('user',function($query){
        return $query->where('will_expire','>',now());
       })->where('id',$device_id)->first();
      
       $request_from=explode('@',$request->from);
       $request_from=$request_from[0];

       $message_id=$request->message_id ?? null;
       $message=$request->message ?? null;
       $device_id=$device_id;

      
       if (strlen($message) < 50 && $device != null && $message != null) {
          $replies=Reply::where('device_id',$device_id)->with('template')->where('keyword','LIKE','%'.$message.'%')->latest()->get();

          foreach ($replies as $key => $reply) {
            if ($reply->match_type == 'equal') {

                if ($reply->reply_type == 'text') {
                  
                  $logs['user_id']=$device->user_id;
                  $logs['device_id']=$device->id;
                  $logs['from']=$device->phone ?? null;
                  $logs['to']=$request_from;
                  $logs['type']='chatbot';
                  $this->saveLog($logs);
                 
                 return response()->json([
                    'message'  => array('text' => $reply->reply),
                    'receiver' => $request->from,
                    'session_id' => $session
                  ],200);

                 
                }
                else{
                    if (!empty($reply->template)) {
                        $template = $reply->template;

                        if (isset($template->body['text'])) {
                            $body = $template->body;
                            $text=$this->formatText($template->body['text'],[],$device->user);
                            $body['text'] = $text;
                            
                        }
                        else{
                            $body=$template->body;
                        }

                        $logs['user_id']=$device->user_id;
                        $logs['device_id']=$device->id;
                        $logs['from']=$device->phone ?? null;
                        $logs['to']=$request_from;
                        $logs['type']='chatbot';
                        $logs['template_id']=$template->id ?? null;
                        $this->saveLog($logs);

                        return response()->json([
                            'message'  => $body,
                            'receiver' => $request->from,
                            'session_id' => $session
                        ],200);
                    }                    
                }
                break;                
            }
          }
       }
       
       return response()->json([
            'message'  => array('text' => null),
            'receiver' => $request->from,
            'session_id' => $session
          ],403);
       
    }
}
