<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Support;
use App\Models\Supportlog;
use DB;
use Auth;
class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:support');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        

        $supports=Support::query();
        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $supports = $supports->whereHas('user',function($q) use ($request){
                    return $q->where('email',$request->search);
                });
            }
            else{
                $supports = $supports->where($request->type,'LIKE','%'.$request->search.'%');
            }
           
        }
        $supports = $supports->with('user')->withCount('conversations')->latest()->paginate(20);

        $pendingSupport=Support::where('status',2)->count();
        $openSupport=Support::where('status',1)->count();
        $closedSupport=Support::where('status',0)->count();
        $totalSupports=$pendingSupport+$openSupport+$closedSupport;

        $type=$request->type;

        return view('admin.support.index',compact('request','supports','pendingSupport','openSupport','closedSupport','totalSupports','type'));
    }

   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $support=Support::with('conversations','user')->findorFail($id);
        $seen= Supportlog::where('is_admin',0)->where('support_id',$id)->update([
            'seen'=>1
        ]);

        return view('admin.support.show',compact('support'));
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
            'message' => 'required|max:1000',
        ]);

        $support=Support::findorFail($id);
        $support->status =$request->status;
        $support->save();

        $support->conversations()->create([
            'comment'  => $request->message,
            'is_admin' => 1,
            'seen' => 0,
            'user_id'  => Auth::id()
        ]);

        return response()->json([
            'redirect' => url('admin/support/'.$support->id),
            'message' => __('Replied Successfully')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
