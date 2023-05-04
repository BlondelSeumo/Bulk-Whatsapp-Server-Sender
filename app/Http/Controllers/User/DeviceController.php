<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Reply;
use App\Models\Smstransaction;
use App\Models\Template;
use App\Models\User;
use DB;
use Auth;
use Http;
use Session;
use Carbon\Carbon;
use App\Traits\Whatsapp;
class DeviceController extends Controller
{
    use Whatsapp;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devices=Device::where('user_id',Auth::id())->withCount('smstransaction')->latest()->paginate(20);
        return view('user.device.index',compact('devices'));
    }

    /**
     * return device statics informations
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deviceStatics()
    {
       $data['total']=Device::where('user_id',Auth::id())->count();
       $data['active']=Device::where('user_id',Auth::id())->where('status',1)->count();
       $data['inActive']=Device::where('user_id',Auth::id())->where('status',0)->count();
       $limit  = json_decode(Auth::user()->plan);
       $limit = $limit->device_limit ?? 0;

       if ($limit == '-1') {
           $data['total']= $data['total'];
       }
       else{
         $data['total']= $data['total'].' / '. $limit;
       }
       
       
       return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.device.create');
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        if (getUserPlanData('device_limit') == false) {
            return response()->json([
                'message'=>__('Maximum Device Limit Exceeded')
            ],401);  
        }

        $validated = $request->validate([
            'name' => 'required|max:100',
        ]);

        $device=new Device;
        $device->user_id=Auth::id();
        $device->name=$request->name;
        $device->save();

        return response()->json([
            'redirect'=>url('user/device/'.$device->uuid.'/qr'),
            'message'=>__('Device Created Successfully')
        ],200);
    }

    public function scanQr($id)
    {
        $device=Device::where('user_id',Auth::id())->where('uuid',$id)->first();
        abort_if(empty($device),404);

        return view('user.device.qr',compact('device'));

    }

    public function getQr($id)
    {
        $device=Device::where('user_id',Auth::id())->where('uuid',$id)->first();
        abort_if(empty($device),404);

        $id=$device->id;
        $response=Http::post(env('WA_SERVER_URL').'/sessions/add',[
                'id'       =>'device_'.$id,
                'isLegacy' =>false
        ]);

        if ($response->status() == 200) {
             $body=json_decode($response->body());
             $data['qr']=$body->data->qr;
             $data['message']=$body->message;
             $device->qr=$body->data->qr;
             $device->save();

             return response()->json($data);
        }
        elseif($response->status() == 409){
            $data['qr']      =$device->qr;
            $data['message'] = __('QR code received, please scan the QR code');
            return response()->json($data);
        }
    }

    public function checkSession($id)
    {
       $device=Device::where('user_id',Auth::id())->where('uuid',$id)->first();
       abort_if(empty($device),404);

       $id=$device->id;
       $response=Http::get(env('WA_SERVER_URL').'/sessions/status/device_'.$id);

       $device->status= $response->status() == 200 ? 1 : 0; 
       if ($response->status() == 200) {
           $res=json_decode($response->body());
           if (isset($res->data->userinfo)) {
             $device->user_name=$res->data->userinfo->name ?? '';
             $phone=str_replace('@s.whatsapp.net', '', $res->data->userinfo->id);
             $phone=explode(':', $phone);
             $phone=$phone[0] ?? null;

             $device->phone=$phone;
             $device->qr=null;
             
           }
           

       }         
       $device->save();

       $message= $response->status() == 200 ? __('Device Connected Successfully') : null;

       return response()->json(['message'=>$message,'connected'=> $response->status() == 200 ? true : false]);

    }

    public function setStatus($device_id,$status)
    {

       $device_id=str_replace('device_','',$device_id);

       $device=Device::where('id',$device_id)->first();
       if (!empty($device)) {
          $device->status=$status;
          $device->save();
       }


    }

    public function webHook(Request $request,$device_id)
    {
       
       $session=$device_id;
       $device_id=str_replace('device_','',$device_id);

       $device=Device::with('user')->whereHas('user')->where('id',$device_id)->first();
       if (empty($device)) {
        return response()->json([
            'message'  => array('text' => 'this is reply'),
            'receiver' => $request->from,
            'session_id' => $session
          ],403);
       }
       
       if (getUserPlanData('chatbot',$device->user_id) == false) {
            return response()->json([
             'message'  => array('text' => 'this is reply'),
             'receiver' => $request->from,
             'session_id' => $session
            ],401);  
        }

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
            'message'  => array('text' => 'this is reply'),
            'receiver' => $request->from,
            'session_id' => $session
          ],403);
       
    }

    public function logoutSession($id)
    {
       $device=Device::where('user_id',Auth::id())->where('uuid',$id)->first();
       abort_if(empty($device),404);

       $device->status=0;
       $device->qr=null;
       $device->save();

       $id=$device->id;
       $response=Http::delete(env('WA_SERVER_URL').'/sessions/delete/device_'.$id);

      return response()->json(['message'=>__('Congratulations! Your Device Successfully Logout')]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $device=Device::where('user_id',Auth::id())->where('uuid',$id)->first();
        abort_if(empty($device),404);

        $posts=Smstransaction::where('user_id',Auth::id())->where('device_id',$device->id)->latest()->paginate();
        $totalUsed=Smstransaction::where('user_id',Auth::id())->where('device_id',$device->id)->count();
        $todaysMessage=Smstransaction::where('user_id',Auth::id())->where('device_id',$device->id)->whereDate('created_at',Carbon::today())->count();
        $monthlyMessages=Smstransaction::where('user_id',Auth::id())
                        ->where('device_id',$device->id)
                        ->where('created_at', '>', now()->subDays(30)->endOfDay())
                        ->count();


        return view('user.device.show',compact('device','posts','totalUsed','todaysMessage','monthlyMessages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $device=Device::where('user_id',Auth::id())->where('uuid',$id)->first();
        abort_if(empty($device),404);
        return view('user.device.edit',compact('device'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
        ]);

        $device=Device::where('user_id',Auth::id())->where('uuid',$id)->first();
        abort_if(empty($device),404);

        $device->name=$request->name;
        $device->save();

        return response()->json([
            'redirect'=>url('/user/device'),
            'message'=>__('Device Updated Successfully')
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $device=Device::where('user_id',Auth::id())->where('uuid',$id)->first();
        abort_if(empty($device),404);
        try {
           if ($device->status == 1) {
            Http::delete(env('WA_SERVER_URL').'/sessions/delete/device_'.$device->id);
         }
        } catch (Exception $e) {
            
        }
        $device->delete();

        return response()->json([
            'message' => __('Congratulations! Your Device Successfully Removed'),
            'redirect' => route('user.device.index')
        ]);
       
    }
}
