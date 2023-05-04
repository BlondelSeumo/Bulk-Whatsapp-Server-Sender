<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Validator;
use Cache;
use Auth;
class MenuController extends Controller
{
    public function __construct(){
      $this->middleware('permission:menu'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::latest()->get();
        $languages = get_option('languages',true);

        $totalMenus =  Menu::count();
        $totalActiveMenus =  Menu::where('status',1)->count();
        $totalDraftMenus =  Menu::where('status',0)->count();
        return view('admin.menu.index', compact('menus', 'languages','totalMenus','totalActiveMenus','totalDraftMenus'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required'],
            'position'=> ['required'],
            'status'=> ['required'],
            'status'=> ['required'],
            'language'=> ['required'],
        ]);

        if ($request->status == 1) {
             Menu::where('position',$request->position)
             ->where('lang', $request->lang)
             ->update(['status' => 0]);
        }  

        $men = new Menu;
        $men->name = $request->name;
        $men->position = $request->position;
        $men->status = $request->status;
        $men->lang = $request->language;
        $men->data = "[]";
        $men->save();

        return response()->json([
            'redirect' => route('admin.menu.index'),
            'message'  => __('Menu Created Successfully.')
        ]);
    }

    public function storeDate(Request $request,$id)
    {
      
        $info = Menu::findOrFail($id);
        $info->data = str_replace('<script>','',$request->data);
        $info->save();

        Cache::forget($info->position . $info->lang);
        return response()->json([
            'message'  => __('Menu Updated Successfully.')
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
        $info = Menu::findOrFail($id);
        $contents = $info->data ?? '';

        return view('admin.menu.show', compact('info','contents'));
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
        $request->validate([
            'name'  => 'required',
            'position'=> 'required',
            'status'=> 'required',
            'status'=> 'required',
            'language'=> 'required',
        ]);

        if ($request->status == 1) {
             Menu::where('position',$request->position)
             ->where('lang', $request->lang)
             ->update(['status' => 0]);
        }  

        $menu = Menu::find($id);
        $menu->name = $request->name;
        $menu->position = $request->position;
        $menu->status = $request->status;
        $menu->lang = $request->language;
        $menu->save();

        Cache::forget($request->position . $request->language);

        return response()->json([
            'redirect' => route('admin.menu.index'),
            'message'  => __('Menu Updated Successfully.')
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
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return response()->json([
            'redirect' => route('admin.menu.index'),
            'message'  => __('Menu Removed Successfully.')
        ]);
    }
}
