<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\App;
use App\Traits\Notifications;
use Auth;
class AppController extends Controller
{

    use Notifications;

    public function __construct(){
         $this->middleware('permission:apps'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $apps = App::query();

        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $apps = $apps->whereHas('user',function($q) use ($request){
                    return $q->where('email',$request->search);
                });
            }
            else{
                $apps = $apps->where($request->type,'LIKE','%'.$request->search.'%');
            }
        }

        $apps = $apps->withCount('liveMessages')->with('user')->latest()->paginate(30);
        $type = $request->type ?? '';

        $totalApps= App::count();
        $totalActiveApps= App::where('status',1)->count();
        $totalInactiveApps= App::where('status',0)->count();

        return view('admin.logs.apps',compact('apps','request','type','totalApps','totalActiveApps','totalInactiveApps'));
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $device = App::findorFail($id);
        $device->delete();

        return response()->json([
            'redirect' => route('admin.apps.index'),
            'message'  => __('App Removed successfully.')
        ]);
    }
}
