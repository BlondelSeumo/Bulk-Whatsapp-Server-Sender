<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Traits\Notifications;
use Auth;
class ContactsController extends Controller
{
    use Notifications;

    public function __construct(){
        $this->middleware('permission:contacts'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $contacts = Contact::query();

        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $contacts = $contacts->whereHas('user',function($q) use ($request){
                    return $q->where('email',$request->search);
                });
            }
            else{
                $contacts = $contacts->where($request->type,'LIKE','%'.$request->search.'%');
            }
        }

        $contacts = $contacts->with('user')->latest()->paginate(30);
        $type = $request->type ?? '';

        $totalContacts= Contact::count();
        $schedulecontacts= Contact::whereHas('schedulecontacts')->count();
       

        return view('admin.logs.contacts',compact('contacts','request','type','totalContacts','schedulecontacts'));
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Contact::findorFail($id);
        $row->delete();

        $title = 'Your a contact was removed by admin';
        $notification['user_id'] = $row->user_id;
        $notification['title']   = $title;
        $notification['url'] = '/user/contact';

        $this->createNotification($notification);

        return response()->json([
            'redirect' => route('admin.contacts.index'),
            'message'  => __('Contacts Removed successfully.')
        ]);
    }
}
