<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Auth;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $notifications = Notification::where('user_id',Auth::id())->latest()->paginate(30);

       return view('user.notifications.index',compact('notifications'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $notifications = Notification::where('user_id',Auth::id())->orderBy('seen','DESC')->latest()->take(5)->get()->map(function($query){
            $data['url'] = url('user/notifications',$query->id);
            $data['title'] = $query->title;
            $data['comment'] = $query->comment;
            $data['created_at'] = $query->created_at->diffForHumans();

            return $data;
       });
       $data['notifications'] = $notifications;
       $data['notifications_unread'] = Notification::where('user_id',Auth::id())->where('seen',0)->count();
       return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = Notification::where('user_id',Auth::id())->findorFail($id);
        $notification->seen = 1;
        $notification->save();

        return redirect($notification->url);
    }

}
