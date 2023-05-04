<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\App;
use App\Models\Device;
use App\Models\Smstransaction;
use App\Models\Smstesttransactions;
use Carbon\Carbon;
class AppsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        $apps=App::where('user_id',Auth::id())->with('device')->withCount('liveMessages')->latest()->paginate(20);
        $devices=Device::where('user_id',Auth::id())->where('status',1)->latest()->get();
        $total = Smstransaction::where('user_id',Auth::id())->where('app_id','!=',null)->count();
        $last30_messages = Smstransaction::where('user_id',Auth::id())
                 ->where('app_id','!=',null)
                 ->where('created_at', '>', now()
                 ->subDays(30)
                 ->endOfDay())
                 ->count();
        $total_app = App::where('user_id',Auth::id())->count();

        $limit  = json_decode(Auth::user()->plan);
        $limit = $limit->apps_limit ?? 0;
        if ($limit == '-1') {
            $limit = number_format($total_app);
        }
        else{
            $limit = number_format($total_app).'/'.$limit;
        }

        return view('user.apps.index',compact('apps','devices','total','last30_messages','total_app','limit'));
    }

    public function logs(Request $request,$uuid)
    {
        $app=App::where('uuid',$uuid)->where('user_id',Auth::id())->first();
        abort_if($app == null,404);

        $logs=Smstransaction::where('user_id',Auth::id())->with('device')->where('app_id',$app->id)->latest()->paginate();
        $totalUsed=Smstransaction::where('user_id',Auth::id())->where('app_id',$app->id)->count();
        
        $todaysMessage=Smstransaction::where('user_id',Auth::id())
                        ->where('app_id',$app->id)
                        ->whereDate('created_at',Carbon::today())
                        ->count();
        $monthlyMessages=Smstransaction::where('user_id',Auth::id())
                        ->where('app_id',$app->id)
                        ->where('created_at', '>', now()->subDays(30)->endOfDay())
                        ->count();

        return view('user.apps.logs',compact('logs','request','totalUsed','todaysMessage','monthlyMessages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('user.apps.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (getUserPlanData('apps_limit') == false) {
            return response()->json([
                'message'=>__('Maximum App Limit Is Exceeded')
            ],401);  
        }

        $validated = $request->validate([
            'name' => 'required|max:50',
            'device'=>'required',
            'website' => 'required|max:80|url',
        ]);

        $device=Device::where('status',1)->where('user_id',Auth::id())->findorFail($request->device);

        $app=new App;
        $app->user_id=Auth::id();
        $app->title=$request->name;
        $app->website=$request->website;
        $app->device_id=$request->device;
        $app->save();

        return response()->json([
            'redirect' => route('user.app.integration',$app->uuid),
            'message' => __('App created successfully.')
        ]);
    }

    public function integration($uuid)
    {
        $info=App::where('uuid',$uuid)->where('user_id',Auth::id())->first();
        abort_if($info == null,404);
        $key=$info->key;
        return view('user.apps.integration',compact('key'));
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $info=App::where('uuid',$id)->where('user_id',Auth::id())->first();
         abort_if($info == null,404);
         $info->delete();

         return response()->json([
            'redirect' => route('user.app.index'),
            'message' => __('App deleted successfully.')
        ]);
    }
}
