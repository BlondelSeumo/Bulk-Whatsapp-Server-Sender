<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Traits\Uploader;
use Cache;
class AboutController extends Controller
{
    use Uploader;

    public function __construct(){
         $this->middleware('permission:about'); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $languages = get_option('languages',true);

       $about=  get_option('about',true);
       $counter_section=  get_option('counter',true);
       

       return view('admin.about.index',compact('about','counter_section','languages'));
    }

  
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        if ($request->type == 'counter') {
            $counter= Option::where('key','counter')->where('lang',$request->lang)->first();
            if (empty($counter)) {
                $counter = new Option;
                $counter->key = 'counter';
                $counter->lang = $request->lang;
            }
            $counter->value = json_encode($request->counter);
            $counter->save();
           
            Cache::forget('counter');

            return response()->json(['message'=>__('Counter Settings Updated...')]);
        }

        if ($request->type == 'about') {
            $data = $request->validate([
                'about_image_1'  => ['image','max:2048'],
                'about_image_2'=> ['image','max:2048'],
            ]);

            $about= Option::where('key','about')->where('lang',$request->lang)->first();
            if (empty($about)) {
                $about = new Option;
                $about->key = 'about';
                $about->lang = $request->lang;
            }

            $about_us=  get_option('about',true);

            $data['breadcrumb_title'] = $request->breadcrumb_title;
            $data['section_title'] = $request->section_title;
            $data['experience'] = $request->experience;
            $data['experience_title'] = $request->experience_title;
            $data['description'] = $request->description;
            $data['button_title'] = $request->button_title;
            $data['button_link'] = $request->button_link;
            $data['facilities'] = $request->facilities;
            $data['introducing_video'] = $request->introducing_video;
            
            $data['about_image_1'] = $about_us->about_image_1 ?? null;
            $data['about_image_2'] = $about_us->about_image_2 ?? null;

            if ($request->hasFile('about_image_1')) {
                $about_image_1 = $this->saveFile($request,'about_image_1');
                $data['about_image_1'] = $about_image_1;

                $this->removeFile($about_us->about_image_1 ?? null);
            }

            if ($request->hasFile('about_image_2')) {
                $about_image_2 = $this->saveFile($request,'about_image_2');
                $data['about_image_2'] = $about_image_2;

                $this->removeFile($about_us->about_image_2 ?? null);
            }


            $about->value = json_encode($data);
            $about->save();
           
           Cache::forget('about');

            return response()->json(['message'=>__('About Section Updated...')]);
        }
    }

}
