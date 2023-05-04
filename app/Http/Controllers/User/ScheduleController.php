<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedulemessage;
use App\Models\Schedulecontact;
use App\Models\Template;
use App\Models\Contact;
use App\Models\Device;
use Carbon\Carbon;
use DateTimeZone;
use Storage;
use Http;
use Auth;
use DB;
class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Schedulemessage::where('user_id',Auth::id())->with('device')->latest()->paginate(20);
        $totalSchedule=Schedulemessage::where('user_id',Auth::id())->count();
        $pendingSchedule=Schedulemessage::where('user_id',Auth::id())->where('status','pending')->count();
        $deliveredSchedule=Schedulemessage::where('user_id',Auth::id())->where('status','delivered')->count();
        $failedSchedule=Schedulemessage::where('user_id',Auth::id())->where('status','rejected')->count();

        return view('user.schedule.index',compact('posts','totalSchedule','pendingSchedule','deliveredSchedule','failedSchedule'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        
        $contacts=Contact::where('user_id',Auth::id())->latest()->get();
        $devices=Device::where('user_id',Auth::id())->where('status',1)->latest()->get();
        $templates=Template::where('user_id',Auth::id())->where('status',1)->latest()->get();

        return view('user.schedule.create',compact('contacts','devices','templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (getUserPlanData('schedule_message') == false) {
            return response()->json([
                 'message'=>__('Schedule message modules is not available your plan')
            ],401);  
        }
        
        $validated = $request->validate([
            'device' => 'required|integer',
            'date' => 'required',
            'title' => 'required|max:100',
            'message_type' => 'required'
        ]);
        if ($request->message_type != 'template') {
           $validated = $request->validate([
                'message' => 'required|max:1000',
            ]);
        }

        if ($request->selectall) {
            $receivers=Contact::where('user_id',Auth::id())->select('id')->get();
            if (count($receivers ?? []) == 0) {
                return response()->json([
                    'message' =>  __('Add some contacts for creating this schedule.'),
                ], 403);
            }
        }
        else{
            $validated = $request->validate([
                'receivers' => 'required',
            ]);
            $receivers=Contact::where('user_id',Auth::id())->whereIn('id',$request->receivers)->select('id')->get();
        }

        if ($request->message_type == 'template') {
            $validated = $request->validate([
                'template' => 'required',
            ]);
            $template=Template::where('user_id',Auth::id())->where('status',1)->findorFail($request->template);
        }

        $device=Device::where('user_id',Auth::id())->where('status',1)->findorFail($request->device);

        if ($device->user_id == Auth::id() || $device->is_admin == 1) {

           
           $receivers_arr=[];

           foreach ($receivers as $key => $receiver) {
               
               array_push($receivers_arr, $receiver->id);
           }
           abort_if(count($receivers_arr) == 0,404);

           

            DB::beginTransaction();
            try {
               

           $schedulemessage=new Schedulemessage;
           $schedulemessage->user_id=Auth::id();
           $schedulemessage->device_id=$request->device;
           $schedulemessage->title=$request->title;
           $schedulemessage->body= $request->message_type != 'template' ? $request->message : null;
           $schedulemessage->date=$request->date;

           $schedulemessage->template_id= $request->message_type == 'template' ? $request->template : null;
           $schedulemessage->save();

           $receivers_arrs=[];
           foreach ($receivers_arr as $key => $receiverr) {
              $arr['contact_id']=$receiverr;
              $arr['schedulemessage_id']=$schedulemessage->id;
              array_push($receivers_arrs, $arr);
           }

           $schedulemessage->schedulecontacts()->insert($receivers_arrs);
            DB::commit();

           return response()->json(__('Schedule message created successfully...!!'),200);

           } catch (\Throwable $th) {
                DB::rollback();
                return response()->json([
                    'message' =>  __('Something was wrong, Please contact with Support.'),
                ], 404);
            }
           
        }
        abort(404);

        
        

    }

    public function filter_body($context)
    {
        $data=str_replace("\\r",'\r',$context);
        $data=str_replace("\\n",'\n',$data);

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info=Schedulemessage::with('device')->where('user_id',Auth::id())->withCount('schedulecontacts')->findorFail($id);
        $contacts=Schedulecontact::where('schedulemessage_id',$id)->whereHas('contact')->with('contact')->paginate(50);
        return view('user.schedule.show',compact('info','contacts'));
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedulemessage=Schedulemessage::where('user_id',Auth::id())->findorFail($id);
        
        
        $schedulemessage->delete();
        return response()->json([
            'message' => __('Schedule Deleted Successfully'),
            'redirect' => route('user.schedule-message.index')
        ]);

    }
}
