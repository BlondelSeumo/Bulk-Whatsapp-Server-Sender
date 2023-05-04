<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Smstransaction;
use Carbon\Carbon;
use Auth;
class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs=Smstransaction::where('user_id',Auth::id())
              ->with('device','app','template')
              ->latest()
              ->paginate(30);
        $total_messages=Smstransaction::where('user_id',Auth::id())->count();
        $today_messages=Smstransaction::where('user_id',Auth::id())
                        ->whereRaw('date(created_at) = ?', [Carbon::now()->format('Y-m-d')] )
                        ->count();
        $last30_messages=Smstransaction::where('user_id',Auth::id())
                            ->where('created_at', '>', now()
                            ->subDays(30)
                            ->endOfDay())
                            ->count();

        return view('user.log.index',compact('logs','total_messages','today_messages','last30_messages'));
    }

}
