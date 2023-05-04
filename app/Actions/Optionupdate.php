<?php

namespace App\Actions;

use Illuminate\Http\Request;
use App\Models\Option;
use Str;
use Artisan;
use App\Traits\Uploader;
use Cache;
class Optionupdate
{
     use Uploader;


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function primaryDataUpdate(Request $request){
        
        $primary_data = Option::where('key','primary_data')->first();
        $optionData = json_decode($primary_data->value);

        if ($request->hasFile('logo')) {
            $newLogo = $this->saveFile($request,'logo');
            $this->removeFile($optionData->logo);
            $optionData->logo = $newLogo;
        }

        if ($request->hasFile('favicon')) {
            $favicon = $this->saveFile($request,'favicon');
            $this->removeFile($optionData->favicon);
            $optionData->favicon = $favicon;

        }

        if ($request->hasFile('footer_logo')) {
            $footer_logo = $this->saveFile($request,'footer_logo');
            $this->removeFile($optionData->footer_logo ?? null);
            $optionData->footer_logo = $footer_logo;
        }

        $optionData->contact_email = $request->contact_email;
        $optionData->contact_phone = $request->contact_phone;
        $optionData->address       = $request->address;
        $optionData->socials       = $request->socials;

        $primary_data->value = json_encode($optionData);
        $primary_data->save();        
           
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function headerFooterUpdate(Request $request)
    {
        $locale = current_locale();

            $header_footer = Option::where('key','header_footer')->where('lang',$locale)->first();
            if (empty($header_footer)) {
                $validated = $request->validate([
                    'footer_button_image' => 'required|image|max:1024',
                    'footer_left_button_image' => 'required|image|max:1024',
                ]);

                $header_footer = new Option;
                $header_footer->key = 'header_footer';
                $header_footer->lang = $locale;

                $newData['header'] = $request->header;
                $newData['footer'] = $request->footer;

                

                $footer_button_image = $this->saveFile($request,'footer_button_image');
                $newData['footer_button_image'] = $footer_button_image;

                $footer_left_button_image = $this->saveFile($request,'footer_left_button_image');
                $newData['footer_left_button_image'] = $footer_left_button_image;

            }
            else{
                $validated = $request->validate([
                    'footer_button_image' => 'image|max:1024',
                    'footer_left_button_image' => 'image|max:1024',
                ]);

                $optionData = json_decode($header_footer->value ?? '');

                $newData['header'] = $request->header;
                $newData['footer'] = $request->footer;               

                
                if ($request->hasFile('footer_button_image')) {
                    $footer_button_image = $this->saveFile($request,'footer_button_image');
                    $this->removeFile($optionData->footer_button_image ?? null);
                    $newData['footer_button_image'] = $footer_button_image;
                    
                }
                else{
                    $newData['footer_button_image'] = $optionData->footer_button_image ?? null;
                }

                if ($request->hasFile('footer_left_button_image')) {
                   $footer_left_button_image = $this->saveFile($request,'footer_left_button_image');
                   $newData['footer_left_button_image'] = $footer_left_button_image;
                }
                else{
                   $newData['footer_left_button_image'] = $optionData->footer_left_button_image ?? null;
                }

                

            }
           
            $header_footer->value = json_encode($newData);
            $header_footer->save();
    }


     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contactPageUpdate(Request $request)
    {
        

        $contact = Option::where('key','contact-page')->first();
        if (empty($contact)) {
            $contact = new Option;
            $contact->key = 'contact-page';
        }

        $contact->value = json_encode($request->data);
        $contact->save();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function homePageUpdate(Request $request)
    {
           

        $locale = current_locale();

        $option = Option::where('key','home-page')->where('lang',$locale)->first();
             if (empty($option)) {
                $validated = $request->validate([
                    'right_button_image' => 'required|image|max:1024',
                    'testimonial_cover' => 'required|image|max:1024',
                    'left_button_image'  => 'required|image|max:1024',
                    'hero_left_image'    => 'required|image|max:1024',
                    'hero_image'         => 'required|image|max:1024',
                    'hero_right_image'   => 'required|image|max:1024',
                    'cta_logo'           => 'required|image|max:1024',
                    'cta_thumbnail'      => 'required|image|max:1024',
                    'platform_thumbnail'             => 'required|image|max:1024',
                    'account_area_thumbnail'      => 'required|image|max:1024',
                    'account_footer_left_image'   => 'required|image|max:1024',
                    'account_footer_right_image'  => 'required|image|max:1024',
                    'account_area_top_thumbnail'  => 'required|image|max:1024',
                    'account_area_bottom_thumbnail'  => 'required|image|max:1024',
                    

                ]);

                $option = new Option;
                $option->key = 'home-page';
                $option->lang = $locale;


                $optionData = $request->data;

                if ($request->hasFile('right_button_image')) {
                    $right_button_image = $this->saveFile($request,'right_button_image');
                    $optionData['right_button_image'] = $right_button_image;
                }

                if ($request->hasFile('left_button_image')) {
                    $left_button_image = $this->saveFile($request,'left_button_image');
                    $optionData['left_button_image'] = $left_button_image;
                }

                if ($request->hasFile('hero_left_image')) {
                    $hero_left_image = $this->saveFile($request,'hero_left_image');
                    $optionData['hero_left_image'] = $hero_left_image;
                }

                if ($request->hasFile('hero_image')) {
                    $hero_image = $this->saveFile($request,'hero_image');
                    $optionData['hero_image'] = $hero_image;
                }

                if ($request->hasFile('hero_right_image')) {
                    $hero_right_image = $this->saveFile($request,'hero_right_image');
                    $optionData['hero_right_image'] = $hero_right_image;
                }

                if ($request->hasFile('cta_logo')) {
                    $cta_logo = $this->saveFile($request,'cta_logo');
                    $optionData['cta_logo'] = $cta_logo;
                }

                if ($request->hasFile('cta_thumbnail')) {
                    $cta_thumbnail = $this->saveFile($request,'cta_thumbnail');
                    $optionData['cta_thumbnail'] = $cta_thumbnail;
                }

                if ($request->hasFile('platform_thumbnail')) {
                    $platform_thumbnail = $this->saveFile($request,'platform_thumbnail');
                    $optionData['platform_thumbnail'] = $platform_thumbnail;
                }

                if ($request->hasFile('account_area_thumbnail')) {
                    $account_area_thumbnail = $this->saveFile($request,'account_area_thumbnail');
                    $optionData['account_area_thumbnail'] = $account_area_thumbnail;
                }

                if ($request->hasFile('account_area_top_thumbnail')) {
                    $account_area_top_thumbnail = $this->saveFile($request,'account_area_top_thumbnail');
                    $optionData['account_area_top_thumbnail'] = $account_area_top_thumbnail;
                }

                if ($request->hasFile('account_area_bottom_thumbnail')) {
                    $account_area_bottom_thumbnail = $this->saveFile($request,'account_area_bottom_thumbnail');
                    $optionData['account_area_bottom_thumbnail'] = $account_area_bottom_thumbnail;
                }

                if ($request->hasFile('account_footer_left_image')) {
                    $account_footer_left_image = $this->saveFile($request,'account_footer_left_image');
                    $optionData['account_footer_left_image'] = $account_footer_left_image;
                }

                if ($request->hasFile('account_footer_right_image')) {
                    $account_footer_right_image = $this->saveFile($request,'account_footer_right_image');
                    $optionData['account_footer_right_image'] = $account_footer_right_image;
                }

                if ($request->hasFile('testimonial_cover')) {
                    $testimonial_cover = $this->saveFile($request,'testimonial_cover');
                    $optionData['testimonial_cover'] = $testimonial_cover;
                }

                if ($request->hasFile('faq_cover')) {
                    $faq_cover = $this->saveFile($request,'faq_cover');
                    $optionData['faq_cover'] = $faq_cover;
                }

                if ($request->hasFile('about_cover')) {
                    $about_cover = $this->saveFile($request,'about_cover');
                    $optionData['about_cover'] = $about_cover;
                }

                $data= json_encode($optionData);
                $option->value = $data;
                $option->save();


             }
             else{
                
                $optionData = $request->data;
                $oldData = json_decode($option->value ?? '');

                if ($request->hasFile('right_button_image')) {
                    $right_button_image = $this->saveFile($request,'right_button_image');
                    $optionData['right_button_image'] = $right_button_image;
                }
                else{
                    $optionData['right_button_image'] = $oldData->right_button_image ?? null;
                }

                if ($request->hasFile('left_button_image')) {
                    $left_button_image = $this->saveFile($request,'left_button_image');
                    $optionData['left_button_image'] = $left_button_image;
                }

                else{
                    $optionData['left_button_image'] = $oldData->left_button_image ?? null;
                }

                if ($request->hasFile('hero_left_image')) {
                    $hero_left_image = $this->saveFile($request,'hero_left_image');
                    $optionData['hero_left_image'] = $hero_left_image;
                }

                else{
                    $optionData['hero_left_image'] = $oldData->hero_left_image ?? null;
                }

                if ($request->hasFile('hero_image')) {
                    $hero_image = $this->saveFile($request,'hero_image');
                    $optionData['hero_image'] = $hero_image;
                }
                else{
                    $optionData['hero_image'] = $oldData->hero_image ?? null;
                } 

                if ($request->hasFile('testimonial_cover')) {
                    $testimonial_cover = $this->saveFile($request,'testimonial_cover');
                    $optionData['testimonial_cover'] = $testimonial_cover;
                }
                else{
                    $optionData['testimonial_cover'] = $oldData->testimonial_cover ?? null;
                }

                if ($request->hasFile('integration_cover')) {
                    $integration_cover = $this->saveFile($request,'integration_cover');
                    $optionData['integration_cover'] = $integration_cover;
                }
                else{
                    $optionData['integration_cover'] = $oldData->integration_cover ?? null;
                }

                if ($request->hasFile('integration_left')) {
                    $integration_left = $this->saveFile($request,'integration_left');
                    $optionData['integration_left'] = $integration_left;
                }
                else{
                    $optionData['integration_left'] = $oldData->integration_left ?? null;
                }

                if ($request->hasFile('integration_right')) {
                    $integration_right = $this->saveFile($request,'integration_right');
                    $optionData['integration_right'] = $integration_right;
                }
                else{
                    $optionData['integration_right'] = $oldData->integration_right ?? null;
                }

                if ($request->hasFile('hero_right_image')) {
                    $hero_right_image = $this->saveFile($request,'hero_right_image');
                    $optionData['hero_right_image'] = $hero_right_image;
                }
                else{
                    $optionData['hero_right_image'] = $oldData->hero_right_image ?? null;
                }

                if ($request->hasFile('cta_logo')) {
                    $cta_logo = $this->saveFile($request,'cta_logo');
                    $optionData['cta_logo'] = $cta_logo;
                }
                else{
                    $optionData['cta_logo'] = $oldData->cta_logo ?? null;
                }

                if ($request->hasFile('cta_thumbnail')) {
                    $cta_thumbnail = $this->saveFile($request,'cta_thumbnail');
                    $optionData['cta_thumbnail'] = $cta_thumbnail;
                }
                else{
                    $optionData['cta_thumbnail'] = $oldData->cta_thumbnail ?? null;
                }

                if ($request->hasFile('platform_thumbnail')) {
                    $platform_thumbnail = $this->saveFile($request,'platform_thumbnail');
                    $optionData['platform_thumbnail'] = $platform_thumbnail;
                }
                else{
                    $optionData['platform_thumbnail'] = $oldData->platform_thumbnail ?? null;
                }

                if ($request->hasFile('account_area_thumbnail')) {
                    $account_area_thumbnail = $this->saveFile($request,'account_area_thumbnail');
                    $optionData['account_area_thumbnail'] = $account_area_thumbnail;
                }
                else{
                    $optionData['account_area_thumbnail'] = $oldData->account_area_thumbnail ?? null;
                }

                if ($request->hasFile('account_area_top_thumbnail')) {
                    $account_area_top_thumbnail = $this->saveFile($request,'account_area_top_thumbnail');
                    $optionData['account_area_top_thumbnail'] = $account_area_top_thumbnail;
                }
                else{
                    $optionData['account_area_top_thumbnail'] = $oldData->account_area_top_thumbnail ?? null;
                }

                if ($request->hasFile('account_area_bottom_thumbnail')) {
                    $account_area_bottom_thumbnail = $this->saveFile($request,'account_area_bottom_thumbnail');
                    $optionData['account_area_bottom_thumbnail'] = $account_area_bottom_thumbnail;
                }
                else{
                    $optionData['account_area_bottom_thumbnail'] = $oldData->account_area_bottom_thumbnail ?? null;
                }

                if ($request->hasFile('account_footer_left_image')) {
                    $account_footer_left_image = $this->saveFile($request,'account_footer_left_image');
                    $optionData['account_footer_left_image'] = $account_footer_left_image;
                }
                else{
                    $optionData['account_footer_left_image'] = $oldData->account_footer_left_image ?? null;
                }

                if ($request->hasFile('account_footer_right_image')) {
                    $account_footer_right_image = $this->saveFile($request,'account_footer_right_image');
                    $optionData['account_footer_right_image'] = $account_footer_right_image;
                }
                else{
                    $optionData['account_footer_right_image'] = $oldData->account_footer_right_image ?? null;
                }

                if ($request->hasFile('faq_cover')) {
                    $faq_cover = $this->saveFile($request,'faq_cover');
                    $optionData['faq_cover'] = $faq_cover;
                }
                else{
                    $optionData['faq_cover'] = $oldData->faq_cover ?? null;
                }

                if ($request->hasFile('about_cover')) {
                    $about_cover = $this->saveFile($request,'about_cover');
                    $optionData['about_cover'] = $about_cover;
                }
                else{
                    $optionData['about_cover'] = $oldData->about_cover ?? null;
                }

                

                $data= json_encode($optionData);
                $option->value = $data;
                $option->save();

        }

    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function whyChoose(Request $request)
    {
       $locale = current_locale();

        $option = Option::where('key','why-choose')->where('lang',$locale)->first();
        if (empty($option)) {
            $validated = $request->validate([
                
                'left_button_image' => 'required|image|max:1024',
                'right_button_image' => 'required|image|max:1024',
                'left_block_image' => 'required|image|max:1024',
                'center_block_image' => 'required|image|max:1024',
                'right_block_image' => 'required|image|max:1024',

            ]);

            $option = new Option;
            $option->key = 'why-choose';
            $option->lang = $locale;

            $optionData = $request->data;

            
            $left_button_image = $this->saveFile($request,'left_button_image');
            $optionData['left_button_image'] = $left_button_image;

            $right_button_image = $this->saveFile($request,'right_button_image');
            $optionData['right_button_image'] = $right_button_image;

            $left_block_image = $this->saveFile($request,'left_block_image');
            $optionData['left_block_image'] = $left_block_image;

            $center_block_image = $this->saveFile($request,'center_block_image');
            $optionData['center_block_image'] = $center_block_image;

            $right_block_image = $this->saveFile($request,'right_block_image');
            $optionData['right_block_image'] = $right_block_image;
            


        }
        else{

             $validated = $request->validate([
                
                'left_button_image' => 'image|max:1024',
                'right_button_image' => 'image|max:1024',
                'left_block_image' => 'image|max:1024',
                'center_block_image' => 'image|max:1024',
                'right_block_image' => 'image|max:1024',

            ]);

             $optionData = $request->data;
             $oldData = json_decode($option->value ?? '');

            
            if ($request->hasFile('left_button_image')) {
                $left_button_image = $this->saveFile($request,'left_button_image');
                $optionData['left_button_image'] = $left_button_image;
            }
            else{                
                $optionData['left_button_image'] = $oldData->left_button_image ?? null;
            }


            if ($request->hasFile('right_button_image')) {
                $right_button_image = $this->saveFile($request,'right_button_image');
                $optionData['right_button_image'] = $right_button_image;
            }
            else{                
                $optionData['right_button_image'] = $oldData->right_button_image ?? null;
            }


            if ($request->hasFile('left_block_image')) {
                $left_block_image = $this->saveFile($request,'left_block_image');
                $optionData['left_block_image'] = $left_block_image;
            }
            else{                
                $optionData['left_block_image'] = $oldData->left_block_image ?? null;
            }


            if ($request->hasFile('center_block_image')) {
                $center_block_image = $this->saveFile($request,'center_block_image');
                $optionData['center_block_image'] = $center_block_image;
            }
            else{                
                $optionData['center_block_image'] = $oldData->center_block_image ?? null;
            }

            if ($request->hasFile('right_block_image')) {
                $right_block_image = $this->saveFile($request,'right_block_image');
                $optionData['right_block_image'] = $right_block_image;
            }
            else{                
                $optionData['right_block_image'] = $oldData->right_block_image ?? null;
            }

        }

        $data= json_encode($optionData);
        $option->value = $data;
        $option->save();

    }
}