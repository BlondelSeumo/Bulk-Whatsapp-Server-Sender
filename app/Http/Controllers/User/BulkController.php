<?php

namespace App\Http\Controllers\User;

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
use Carbon\Carbon;
use App\Traits\Whatsapp;
use Http;
use Auth;
use Str;
class BulkController extends Controller
{
    use Whatsapp;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Smstransaction::where('user_id',Auth::id())->with('device')->with('template')->where('type','bulk-message')->latest()->paginate(20);
        $total=Smstransaction::where('user_id',Auth::id())->where('type','bulk-message')->count();
        $today_transaction=Smstransaction::where('user_id',Auth::id())
                           ->where('type','bulk-message')
                           ->whereRaw('date(created_at) = ?', [Carbon::now()->format('Y-m-d')] )
                           ->count();
        $last30_messages=Smstransaction::where('user_id',Auth::id())
                           ->where('type','bulk-message')
                           ->where('created_at', '>', now()
                           ->subDays(30)
                           ->endOfDay())
                           ->count();
                                              
        $devices=Device::where('user_id',Auth::id())->where('status',1)->latest()->get();
        $templates=Template::where('user_id',Auth::id())->where('status',1)->latest()->get();
        $contacts=Contact::where('user_id',Auth::id())->latest()->get();

        return view('user.whatsapp.bulk.index',compact('posts','total','today_transaction','last30_messages','devices','templates','contacts'));
    }

    public function create()
    {
        $devices=Device::where('user_id',Auth::id())->where('status',1)->latest()->get();
        $contacts=Contact::where('user_id',Auth::id())->latest()->get();

        return view('user.whatsapp.bulk.multiple',compact('devices','contacts'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        $validated = $request->validate([
            'phone'   => 'required|numeric',
            'message' => 'required|max:1000',
            'device' => 'required',
        ]);

        
        $device=Device::where('user_id',Auth::id())->where('status',1)->findorFail($request->device);
        $phone=str_replace('+', '', $request->phone);

        $whatsapp= $this->messageSend($request->all(),$device->id,$phone,'plain-text');

        if ($whatsapp['status'] != 200) {
            return response()->json([
                    'message' => $whatsapp['message'],
                ], $whatsapp['status']);
        }

        else{
           
           $logs['user_id']=Auth::id();
           $logs['device_id']=$device->id;
           $logs['from']=$device->phone ?? null;
           $logs['to']=$phone;
           $logs['type']='bulk-message';
           $this->saveLog($logs);
           
           return response()->json([
                    'message' => __('Message sent successfully..!!'),
                ], 200);
        } 
        
        
    }


    //creating record
    public function createTransaction($arr)
    {
       $trans=new Smstransaction;
       foreach ($arr as $key => $value) {
           $trans->$key=$value;
       }
       $trans->save();

       return $trans;
    }

    public function submitRequest(Bulkrequest $request)
    {
      
        $user=User::where('status',1)->where('authkey',$request->authkey)->first();

        $app=App::where('key',$request->appkey)->whereHas('device')->with('device')->where('status',1)->first();

        
       
        if ($user == null || $app == null) {
            return response()->json(['error'=>'Invalid Auth and AppKey'],401);
        }

        if (getUserPlanData('messages_limit') == false) {
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
            
            $logs['user_id']=Auth::id();
            $logs['device_id']=$app->device_id;
            $logs['from']=$app->device->phone ?? null;
            $logs['to']=$request->to;
            $logs['type']='bulk-message';
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

    public function sendBulkToContacts($id,$device_id)
    {
        $template=Template::where('user_id',Auth::id())->findorFail($id);
        $templates=Template::where('user_id',Auth::id())->where('status',1)->latest()->get();
        $contacts=Contact::where('user_id',Auth::id())->latest()->get();
        $device=Device::where('user_id',Auth::id())->where('status',1)->where('uuid',$device_id)->first();
        $devices=Device::where('user_id',Auth::id())->where('status',1)->latest()->get();


        abort_if(empty($device),404);

        return view('user.template.bulk',compact('template','templates','contacts','device','devices'));
    }

    public function sendMessageToContact(Request $request)
    {
        if (getUserPlanData('messages_limit') == false) {
            return response()->json([
                'message'=>__('Maximum Monthly Messages Limit Exceeded')
            ],401);  
        }

            $validated = $request->validate([
              'contact'   => ['required'],
              'template'   => ['required'], 
            ]);

            $template=Template::where('user_id',Auth::id())->where('status',1)->findorFail($request->template);
            $device=Device::where('user_id',Auth::id())->where('status',1)->findorFail($request->device);
            $contact=Contact::where('user_id',Auth::id())->findorFail($request->contact);
            $user=User::where('id',Auth::id())->first();

             if (isset($template->body['text'])) {
                $formatText=$this->formatText($template->body['text'],$contact,$user);
                $body=$template->body;
                $body['text']=$formatText;
                $logs['template_id']=$template->id;
            }
            else{
                $body=$template->body;
            }


            $response = $this->messageSend($body,$device->id,$contact->phone,$template->type,true,1000);
            if ($response['status'] == 200) {

                $logs['user_id']=Auth::id();
                $logs['device_id']=$device->id;
                $logs['from']=$device->phone ?? null;
                $logs['to']=$contact->phone;
                $logs['type']='bulk-message';
                $this->saveLog($logs);

                return response()->json([
                    'message'  => __('Message Sent Successfully...'),
                ], 200);

            }

            return response()->json([
                'message'  => __('!Opps Request Failed'),
            ], 401);
            
    }
   

    public function templateWithMessage()
    {
       
        $templates=Template::where('user_id',Auth::id())->where('status',1)->latest()->get();
        $contacts=Contact::where('user_id',Auth::id())->latest()->get();
        $devices=Device::where('user_id',Auth::id())->where('status',1)->latest()->get();

        return view('user.template.template',compact('templates','contacts','devices'));
    }


}
