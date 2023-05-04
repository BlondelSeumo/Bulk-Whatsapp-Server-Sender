<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Traits\Uploader;
use App\Actions\Optionupdate;
use Cache;
class SettingsController extends Controller
{
    use Uploader;
    

    public function __construct()
    {
        $this->middleware('permission:page-settings');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locale = current_locale();
        $primary_data = get_option('primary_data',true); 
        $headerFooter = Option::where('key','header_footer')->where('lang',$locale)->first();
        $headerFooter = json_decode($headerFooter->value ?? '');
        $contact_page= get_option('contact-page',true);
        $home = get_option('home-page',true,true);
        $features_area =  $home->brand->status ?? 'active';
        $brand_area = $home->brand->status ?? 'active';
        $account_area = $home->account_area->status ?? 'active';
        $why_choose = get_option('why-choose',true, true);
      
        return view('admin.settings.page-settings',compact('primary_data','headerFooter','contact_page','home','features_area','brand_area','account_area','why_choose'));
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Optionupdate $optionupdate)
    {
    
        if ($id == 'primary_data') {

           $validated = $request->validate([
            'logo' => 'image|max:1024',
            'footer_logo' => 'image|max:1024',
            'favicon' => 'image|max:500',
           ]);


            $optionupdate->primaryDataUpdate($request);
            Cache::flush();

            return response()->json(['message'=>__('Primary settings updated...!')]);

        }

        elseif ($id == 'header_footer') {
            

            $optionupdate->headerFooterUpdate($request);            
            Cache::flush();

            return response()->json(['message'=>__('Header Footer settings updated...!')]);
        }

        elseif ($id == 'contact-page') {

             $optionupdate->contactPageUpdate($request);
             Cache::flush();

            return response()->json(['message'=>__('Contact Page settings updated...!')]);
        }

        elseif ($id == 'home-page') {
            
            $optionupdate->homePageUpdate($request);
            Cache::flush();
            return response()->json(['message'=>__('Home Page settings updated...!')]);

        }

        elseif ($id == 'why-choose') {
            $optionupdate->whyChoose($request);
            Cache::flush();
            return response()->json(['message'=>__('Section settings updated...!')]);
        }
    }

}
