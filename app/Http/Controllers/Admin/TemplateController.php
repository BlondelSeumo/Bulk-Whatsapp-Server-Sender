<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Traits\Notifications;
use Auth;
class TemplateController extends Controller
{
    use Notifications;

    public function __construct(){
         $this->middleware('permission:templates'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $templates = Template::query();

        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $templates = $templates->whereHas('user',function($q) use ($request){
                    return $q->where('email',$request->search);
                });
            }
            else{
                $templates = $templates->where($request->type,'LIKE','%'.$request->search.'%');
            }
        }

        $templates = $templates->with('user')->withCount('smstransaction')->latest()->paginate(30);
        $type = $request->type ?? '';

        $totalActiveTemplates= Template::where('status',1)->count();
        $totalInActiveTemplates= Template::where('status',0)->count();
        $totalTemplates= Template::count();
       

        return view('admin.logs.templates',compact('templates','request','type','totalActiveTemplates','totalInActiveTemplates','totalTemplates'));
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Template::findorFail($id);
        $row->delete();

        $title = 'Your a template was removed by admin';
        $notification['user_id'] = $row->user_id;
        $notification['title']   = $title;
        $notification['url'] = '/user/template';

        $this->createNotification($notification);

        return response()->json([
            'redirect' => route('admin.template.index'),
            'message'  => __('Template Removed successfully.')
        ]);
    }
}
