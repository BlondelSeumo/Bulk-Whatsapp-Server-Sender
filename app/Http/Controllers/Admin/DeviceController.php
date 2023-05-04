<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Traits\Notifications;
use Auth;
use Http;
class DeviceController extends Controller
{
    use Notifications;

    public function __construct(){
         $this->middleware('permission:device'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $devices = Device::query();

        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $devices = $devices->whereHas('user',function($q) use ($request){
                    return $q->where('email',$request->search);
                });
            }
            else{
                $devices = $devices->where($request->type,'LIKE','%'.$request->search.'%');
            }
        }

        $devices = $devices->withCount('smstransaction')->with('user')->latest()->paginate(30);
        $type = $request->type ?? '';

        $totalDevices= Device::count();
        $totalActiveDevices= Device::where('status',1)->count();
        $totalInactiveDevices= Device::where('status',0)->count();

        return view('admin.devices.index',compact('devices','request','type','totalDevices','totalActiveDevices','totalInactiveDevices'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $device = Device::findorFail($id);
        $device->delete();

        $title = 'Your a device was removed by admin';
        $notification['user_id'] = $device->user_id;
        $notification['title']   = $title;
        $notification['url'] = '/user/device';

        $this->createNotification($notification);

        try {
           if ($device->status == 1) {
            Http::delete(env('WA_SERVER_URL').'/sessions/delete/device_'.$device->id);
         }
        } catch (Exception $e) {
            
        }

        return response()->json([
            'redirect' => route('admin.devices.index'),
            'message'  => __('Device Removed successfully.')
        ]);
    }
}
