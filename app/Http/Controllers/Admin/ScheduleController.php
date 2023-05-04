<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedulemessage;
use App\Traits\Notifications;
use Auth;
class ScheduleController extends Controller
{
    use Notifications;

    public function __construct(){
         $this->middleware('permission:schedule'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $schedulemessages = Schedulemessage::query();

        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $schedulemessages = $schedulemessages->whereHas('user',function($q) use ($request){
                    return $q->where('email',$request->search);
                });
            }
            else{
                $schedulemessages = $schedulemessages->where($request->type,'LIKE','%'.$request->search.'%');
            }
        }

        $schedulemessages = $schedulemessages->with('user','device')->withCount('schedulecontacts')->latest()->paginate(30);
        $type = $request->type ?? '';

        $totalSchedules=Schedulemessage::count();
        $pendingSchedules=Schedulemessage::where('status','pending')->count();
        $deliveredSchedules=Schedulemessage::where('status','delivered')->count();
       
       

        return view('admin.logs.schedules',compact('schedulemessages','request','type','totalSchedules','pendingSchedules','deliveredSchedules'));
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Schedulemessage::findorFail($id);
        $row->delete();

        $title = 'Your a schedule was removed by admin';
        $notification['user_id'] = $row->user_id;
        $notification['title']   = $title;
        $notification['url'] = '/user/schedules';

        $this->createNotification($notification);

        return response()->json([
            'redirect' => route('admin.schedules.index'),
            'message'  => __('Schedule Removed successfully.')
        ]);
    }
}
