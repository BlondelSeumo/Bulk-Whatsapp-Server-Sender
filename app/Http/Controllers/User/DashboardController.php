<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Smstransaction;
use App\Models\Schedulemessage;
use App\Models\Contact;
use Carbon\Carbon;
use Auth;
use Session;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->will_expire != null) {
            $nextDate= Carbon::now()->addDays(7)->format('Y-m-d');
            if (Auth::user()->will_expire <= now()) {
                Session::flash('saas_error', __('Your subscription was expired at '.Carbon::parse(Auth::user()->will_expire)->diffForHumans().' please renew the subscription'));
            }

            elseif(Auth::user()->will_expire <= $nextDate){
                Session::flash('saas_error', __('Your subscription is ending in '.Carbon::parse(Auth::user()->will_expire)->diffForHumans()));
            }
        }
       
        return view('user.dashboard');
    }

    public function dashboardData()
    {
        $data['devicesCount'] = Device::where('user_id',Auth::id())->count();
        $data['messagesCount'] = Smstransaction::where('user_id',Auth::id())->count();
        $data['contactCount'] = Contact::where('user_id',Auth::id())->count();
        $data['scheduleCount'] = Schedulemessage::where('status','pending')->where('user_id',Auth::id())->count();
        
        $data['devices'] = Device::where('user_id',Auth::id())->withCount('smstransaction')->orderBy('status','DESC')->latest()->get()->map(function($rq){
                $map['uuid']= $rq->uuid;
                $map['name']= $rq->name;
                $map['status']= $rq->status;
                $map['phone']= $rq->phone;
                $map['smstransaction_count']= $rq->smstransaction_count;
                return $map;
        });
        $data['messagesStatics'] = $this->getMessagesTransaction(7);
        $data['typeStatics'] = $this->messagesStatics(7);
        $data['chatbotStatics'] = $this->getChatbotTransaction(7);

        
        return response()->json($data);

    }

    public function getMessagesTransaction($days)
    {
       $statics= Smstransaction::query()->where('user_id',Auth::id())
                ->whereDate('created_at', '>', Carbon::now()->subDays($days))
                ->orderBy('id', 'asc')
                ->selectRaw('date(created_at) date, count(*) smstransactions')
                ->groupBy('date')
                ->get();

        return $statics;
                
    }

    public function getChatbotTransaction($days)
    {
        $statics= Smstransaction::query()
                ->where('user_id',Auth::id())
                ->where('type','chatbot')
                ->whereDate('created_at', '>', Carbon::now()->subDays($days))
                ->orderBy('id', 'asc')
                ->selectRaw('date(created_at) date, count(*) smstransactions')
                ->groupBy('date')
                ->get();

        return $statics;
    }

    public function messagesStatics($days)
    {
        $statics= Smstransaction::query()->where('user_id',Auth::id())
                ->whereDate('created_at', '>', Carbon::now()->subDays($days))
                ->orderBy('id', 'asc')
                ->selectRaw('type type, count(*) smstransactions')
                ->groupBy('type')
                ->get();

        return $statics;
    }
}
