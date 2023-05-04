<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Smstransaction;
use App\Traits\Notifications;
use Auth;
use Carbon\Carbon;
class TransactionController extends Controller
{
    use Notifications;

    public function __construct(){
         $this->middleware('permission:message-transactions'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = Smstransaction::query();

        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $transactions = $transactions->whereHas('user',function($q) use ($request){
                    return $q->where('email',$request->search);
                });
            }
            else{
                $transactions = $transactions->where($request->type,'LIKE','%'.$request->search.'%');
            }
        }

        $transactions = $transactions->with('user','device')->latest()->paginate(30);
        $type = $request->type ?? '';

      
        $total_messages=Smstransaction::count();
        $today_messages=Smstransaction::where('user_id',Auth::id())
                        ->whereRaw('date(created_at) = ?', [Carbon::now()->format('Y-m-d')] )
                        ->count();
        $last30_messages=Smstransaction::where('created_at', '>', now()
                            ->subDays(30)
                            ->endOfDay())
                            ->count();
       
       

        return view('admin.logs.transactions',compact('transactions','request','type','total_messages','today_messages','last30_messages'));
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Smstransaction::findorFail($id);
        $row->delete();

        $title = 'Your a sms transaction was removed by admin';
        $notification['user_id'] = $row->user_id;
        $notification['title']   = $title;
        $notification['url'] = '/user/logs';

        $this->createNotification($notification);

        return response()->json([
            'redirect' => route('admin.message-transactions.index'),
            'message'  => __('Schedule Removed successfully.')
        ]);
    }
}
