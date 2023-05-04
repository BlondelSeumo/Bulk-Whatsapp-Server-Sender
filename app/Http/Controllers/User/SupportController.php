<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Support;
class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $supports=Support::where('user_id',Auth::id())->latest()->withCount('conversations')->paginate(20);
       $openSupport=Support::where('user_id',Auth::id())->where('status',1)->count();
       $pendingSupport=Support::where('user_id',Auth::id())->where('status',2)->count();
       $total=Support::where('user_id',Auth::id())->count();

       return view('user.support.index',compact('supports','openSupport','pendingSupport','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.support.create');
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
            'subject' => 'required|max:100',
            'message' => 'required|max:1000',
        ]);

        $support= new Support;
        $support->user_id=Auth::id();
        $support->subject = $request->subject;
        $support->save();

        $support->conversations()->create([
            'comment'  => $request->message,
            'is_admin' => 0,
            'user_id'  => Auth::id()
        ]);

        return response()->json([
            'redirect' => url('user/support/'.$support->id),
            'message' => __('New Ticket Generated Successfully')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $support=Support::where('user_id',Auth::id())->with('conversations')->findorFail($id);

         return view('user.support.show',compact('support'));
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

        $support=Support::where('user_id',Auth::id())->where('status',1)->findorFail($id);

        $support->conversations()->create([
            'comment'  => $request->message,
            'is_admin' => 0,
            'seen' => 0,
            'user_id'  => Auth::id()
        ]);

        return response()->json([
            'redirect' => url('user/support/'.$support->id),
            'message' => __('Replied Successfully')
        ]);
    }

}
