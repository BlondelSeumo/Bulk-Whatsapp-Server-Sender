<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Support;
use App\Models\User;
use App\Models\Device;
use App\Models\Plan;
use App\Models\Smstransaction;
use Carbon\Carbon;
use Http;
class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function dashboardData()
    {
        $data['orders']          = Order::count();
        $data['pending_order']   = Order::where('status',2)->count();
        $data['open_support']    = Support::where('status',1)->count();
        $data['pending_support'] = Support::where('status',2)->count();
        $data['active_user']     = User::where('status',1)->where('will_expire','>',now())->count();
        $data['active_device']   = Device::where('status',1)->where('phone','!=',null)->count();
        $data['junk_device']     = Device::where('status',0)->where('phone',null)->count();
        $data['todays_messages'] = Smstransaction::whereDate('created_at', Carbon::today())->count();
        $data['todays_user']     = User::whereDate('created_at', Carbon::today())->count();
        $data['recent_orders']   = Order::whereHas('user')->whereHas('plan')->with('user','plan')->latest()->take(5)->get()->map(function($query){
                                         $data['avatar'] = asset($query->user->avatar != null ? $query->user->avatar : 'https://ui-avatars.com/api/?name='.$query->user->name);
                                         $data['name']      = $query->user->name; 
                                         $data['plan']      = $query->plan->title; 
                                         $data['invoice']   = $query->invoice_no; 
                                         $data['amount']    = amount_format($query->amount,'icon');
                                         $data['created_at']= $query->created_at->diffForHumans(); 
                                         $data['link']      = url('admin/order/'.$query->id);

                                         return $data;
                                    });
        $data['popular_plans']  = Plan::whereHas('orders')->withCount('activeuser')->withCount('orders')->orderBy('orders_count','DESC')->withSum('orders','amount')->get()->map(function($query){
                                        $data['name']       = $query->title;
                                        $data['activeuser'] = number_format($query->activeuser_count);
                                        $data['orders_count'] = number_format($query->orders_count);
                                        $data['total_amount'] = amount_format($query->orders_sum_amount,'icon');

                                        return $data;
                                });

        return response()->json($data);
    }


    public function salesOverView(Request $request)
    {
        $range = $request->type;

        $orders= Order::query();
        if ($range == 'Monthly') {
            $orders= $orders->whereYear('created_at', Carbon::now()->year);
            $orders= $orders->whereMonth('created_at', Carbon::now()->month);
            $orders= $orders->selectRaw('date(created_at) date, sum(amount) amount');
            $orders  = $orders->groupBy('date')->get();  
        }
        elseif ($range == 'Yearly') {
            $orders= $orders->whereYear('created_at', Carbon::now()->year);
            $orders= $orders->selectRaw('monthname(created_at) date, sum(amount) amount');
            $orders  = $orders->groupBy('date')->get();
        }
        elseif ($range == 'Weekly') {
           $orders= $orders->whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
           $orders= $orders->selectRaw('date(created_at) date, sum(amount) amount');
           $orders  = $orders->groupBy('date')->get();
        }

        return response()->json(['orders'=> $orders]);
     

    }

    public function waServerStatus()
    {
        $response = Http::get(env('WA_SERVER_URL').'/sessions/server-status');

        return response()->json(['status'=>$response->status()]);
    }
}
