<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Http;
use App\Models\Template;
use App\Models\Device;
use App\Traits\Whatsapp;
use Storage;
use Auth;
class TemplateController extends Controller
{
    
    use Whatsapp;

    //return template requeest form page
    public function index()
    {  
        $templates=Template::where('user_id',Auth::id())->latest()->paginate(20);
        $active_templates=Template::where('user_id',Auth::id())->where('status',1)->count();
        $inactive_templates=Template::where('user_id',Auth::id())->where('status',0)->count();
        $total_templates=Template::where('user_id',Auth::id())->count();
        $limit  = json_decode(Auth::user()->plan);
        $limit = $limit->template_limit ?? 0;

        if ($limit == '-1') {
            $limit = number_format($total_templates);
        }
        else{
            $limit = number_format($total_templates).' / '.$limit;
        }

        return view('user.template.index',compact('templates','active_templates','inactive_templates','total_templates','limit'));
    }

    public function create()
    {
        return view('user.template.create');
    }

    public function store(Request $request,$type)
    {
        if (getUserPlanData('template_limit') == false) {
                return response()->json([
                    'message'=>__('Maximum Template Limit Exceeded')
                ],401);  
        }

        $validated = $request->validate([
            'template_name' => 'required|max:100',
        ]);

        if ($type == 'text-with-media') {
            $validated = $request->validate([
                'file' => 'required|mimes:jpg,jpeg,png,webp,gif,pdf,docx,xlsx,csv,txt|max:1000',
                'message' => 'required|max:1000',
            ]);

            $file=$this->saveFile($request,'file');
            $request['attachment']=$file;

        }
        elseif ($type == 'text-with-vcard') {
            $validated = $request->validate([
                'display_name' => 'required|max:100',
                'full_name' => 'required|max:100',
                'org_name' => 'required|max:100',
                'contact_number' => ['required', new Phone,'max:20'],
                'wa_number' => ['required', new Phone,'max:20'],
                
            ]);
        }
        elseif ($type == 'text-with-button') {
            $validated = $request->validate([
                'footer_text' => 'required|max:100',
                'buttons.*' => 'required|max:50',
                'message' => 'required|max:1000',
            ]);

             if (count($request->buttons) > 3) {
                return response()->json([
                    'message' => __('Maximum Button Limit Is 3'),
                ], 403);
             }
        }
        elseif ($type == 'text-with-template') {
            $validated = $request->validate([
                'footer_text' => 'required|max:100',
                'buttons.*' => 'required|max:50',
                'message' => 'required|max:1000',
            ]);

            if (count($request->buttons) > 3) {
                return response()->json([
                    'message' => __('Maximum Button Limit Is 3'),
                ], 403);
            }

            $is_valid=true;
            $error_message= __('Please Follow the site rules');
            $types=['urlButton','callButton','quickReplyButton'];
            $properties=['displaytext','action','type'];

            foreach ($request->buttons as $key => $button) {
                if (count($button) < 3) {
                   $is_valid = false;
                   break;
                }
                else{
                     

                     foreach ($button as $buttonKey => $buttonValue) {
                        if ($buttonKey == 'type') {
                            if (!in_array($buttonValue, $types)) {
                              $is_valid = false;
                              break;
                            }
                        }
                        
                        if (!in_array($buttonKey, $properties)) {
                            $is_valid = false;
                            break;
                        }

                        else{
                           
                           
                            if($buttonKey == 'action'){

                                if (!empty($buttonValue)) {
                                    if (strlen($buttonValue) > 50) {
                                        $error_message=__('Maximum Button Value Limit 50');
                                        $is_valid = false;
                                    }
                                }
                                if ($button['type'] != 'quickReplyButton') {
                                     if (empty($buttonValue)) {

                                        $error_message=__('fill up all the fields');
                                        $is_valid = false;
                                     }
                                }

                                
                            }
                            else{
                               

                                if (empty($buttonValue) || $buttonValue == null) {

                                    $error_message= __('fill up all the fields');
                                    $is_valid = false;
                                    break;
                                }
                                else{
                                    if (strlen($buttonValue) > 50) {
                                        $error_message=__('Maximum Button Value Limit 50');
                                        $is_valid = false;
                                    }
                                }

                            }

                        }

                    }
                }
               
            }

            if ($is_valid == false) {
                return response()->json([
                    'message' => $error_message,
                ], 403);
            }
        }
        elseif ($type == 'text-with-location') {
            $validated = $request->validate([
                'degreesLatitude' => 'required|max:100',
                'degreesLongitude' => 'required|max:100',
            ]);
        }
        elseif ($type == 'text-with-list') {
            $validated = $request->validate([
                'header_title' => 'required|max:30',
                'message' => 'required|max:300',
                'footer_text' => 'required|max:30',
                'button_text' => 'required|max:30',
                'section.*' => 'required|max:1000',

            ]);

            $is_valid= count($request->section ?? []) > 20 ? false : true;
            $error_message=__('Maximum Section Limit Is 20');

            if ($is_valid == false) {
                return response()->json([
                    'message' => $error_message,
                ], 403);
            }



            foreach ($request->section as $key => $section) {
            
               if (count($section['value'] ?? []) == 0) {
                   $is_valid=false;
                   $error_message=__('Fill up the list option value');

                   break;
               }
               elseif ($section['title'] == null || !$section['title']) {
                   $is_valid=false;
                   $error_message=__('Fill up all the title field');

                   break;
               }
               elseif (strlen($section['title']) > 50) {
                   $is_valid=false;
                   $error_message=__('Maximum title limit is 50');

                   break;
               }
               else{
                foreach ($section['value'] as $value_key => $value) {
                    if (empty($value['title'])) {
                     $is_valid=false;
                     $error_message=__('Option title is required');

                     break;
                    }
                    elseif (strlen($value['title']) > 50) {
                     $is_valid=false;
                     $error_message=__('List value name maximum word limit is 50');

                     break;
                    }
                    elseif (strlen($value['description']) > 50) {
                        $is_valid=false;
                        $error_message=__('List value description maximum word limit is 50');

                        break;
                    }
                }
               }
            }

            if ($is_valid == false) {
                return response()->json([
                    'message' => $error_message,
                ], 403);
            }
        }


        $template=$this->saveTemplate($request->all(), $request->message,$type,Auth::id());
        if ($template == false) {
            return response()->json([
                'message' => __('Maximum Template Limit Exceeded'),
            ], 403);
        }

        return response()->json([
            'message' => __('Template created successfully..!!'),
        ], 200);
    }

    public function edit($id)
    {
        $template=Template::where('user_id',Auth::id())->findorFail($id);
        
        if ($template->type == 'text-with-media') {
            $component='user.template.edit.media';
        }
        elseif ($template->type == 'text-with-location') {
            $component='user.template.edit.location';
        }
        elseif ($template->type == 'text-with-button') {
            $component='user.template.edit.button';
        }
        elseif ($template->type == 'text-with-template') {
            $component='user.template.edit.template';
        }
        elseif ($template->type == 'text-with-list') {
            $component='user.template.edit.list';
        }
        else{
            $component='user.template.edit.plaintext';
        }

        return view('user.template.edit',compact('template','component'));
    }

    public function update(Request $request,$id)
    {

        $template=Template::where('user_id',Auth::id())->findorFail($id);
        $type=$template->type;

        $validated = $request->validate([
            'template_name' => 'required|max:100',
        ]);

        if ($type == 'text-with-media') {
            $validated = $request->validate([
                'file' => 'mimes:jpg,jpeg,png,webp,gif,pdf,docx,xlsx,csv,txt|max:1000',
                'message' => 'required|max:1000',
            ]);

            if ($request->hasFile('file')) {
                $file=$this->saveFile($request,'file');
                $exists_file='';

                if (isset($template->body['image'])) {
                    $exists_file=$template->body['image']['url'];
                }
                elseif (isset($template->body['attachment'])) {
                    $exists_file=$template->body['attachment']['url'];
                }



                if ($exists_file != '') {
                    $fileArr=explode('uploads', $exists_file);
                    if (isset($fileArr[1])) {
                        $exists_file='uploads'.$fileArr[1];
                        if (Storage::exists($exists_file)) {
                            Storage::delete($exists_file);
                        }

                    }
                }
            }
            else{
                if (isset($template->body['image'])) {
                    $file=$template->body['image']['url'];
                }
                elseif (isset($template->body['attachment'])) {
                    $file=$template->body['attachment']['url'];
                }
            }
            
            $request['attachment']=$file;

        }
        elseif ($type == 'text-with-vcard') {
            $validated = $request->validate([
                'display_name' => 'required|max:100',
                'full_name' => 'required|max:100',
                'org_name' => 'required|max:100',
                'contact_number' => ['required', new Phone,'max:20'],
                'wa_number' => ['required', new Phone,'max:20'],
                
            ]);
        }
        elseif ($type == 'text-with-button') {
            $validated = $request->validate([
                'footer_text' => 'required|max:100',
                'buttons.*' => 'required|max:50',
                'message' => 'required|max:1000',
            ]);

             if (count($request->buttons) > 3) {
                return response()->json([
                    'message' => __('Maximum Button Limit Is 3'),
                ], 403);
             }
        }
        elseif ($type == 'text-with-template') {
            $validated = $request->validate([
                'footer_text' => 'required|max:100',
                'buttons.*' => 'required|max:50',
                'message' => 'required|max:1000',
            ]);

            if (count($request->buttons) > 3) {
                return response()->json([
                    'message' => __('Maximum Button Limit Is 3'),
                ], 403);
            }

            $is_valid=true;
            $error_message= __('Please Follow the site rules');
            $types=['urlButton','callButton','quickReplyButton'];
            $properties=['displaytext','action','type'];

            foreach ($request->buttons as $key => $button) {
                if (count($button) < 3) {
                   $is_valid = false;
                   break;
                }
                else{
                     

                     foreach ($button as $buttonKey => $buttonValue) {
                        if ($buttonKey == 'type') {
                            if (!in_array($buttonValue, $types)) {
                              $is_valid = false;
                              break;
                            }
                        }
                        
                        if (!in_array($buttonKey, $properties)) {
                            $is_valid = false;
                            break;
                        }

                        else{
                           
                           
                            if($buttonKey == 'action'){

                                if (!empty($buttonValue)) {
                                    if (strlen($buttonValue) > 50) {
                                        $error_message=__('Maximum Button Value Limit 50');
                                        $is_valid = false;
                                    }
                                }
                                if ($button['type'] != 'quickReplyButton') {
                                     if (empty($buttonValue)) {

                                        $error_message=__('fill up all the fields');
                                        $is_valid = false;
                                     }
                                }

                                
                            }
                            else{
                               

                                if (empty($buttonValue) || $buttonValue == null) {

                                    $error_message= __('fill up all the fields');
                                    $is_valid = false;
                                    break;
                                }
                                else{
                                    if (strlen($buttonValue) > 50) {
                                        $error_message=__('Maximum Button Value Limit 50');
                                        $is_valid = false;
                                    }
                                }

                            }

                        }

                    }
                }
               
            }

            if ($is_valid == false) {
                return response()->json([
                    'message' => $error_message,
                ], 403);
            }
        }
        elseif ($type == 'text-with-location') {
            $validated = $request->validate([
                'degreesLatitude' => 'required|max:100',
                'degreesLongitude' => 'required|max:100',
            ]);
        }
        elseif ($type == 'text-with-list') {
            $validated = $request->validate([
                'header_title' => 'required|max:30',
                'message' => 'required|max:300',
                'footer_text' => 'required|max:30',
                'button_text' => 'required|max:30',
                'section.*' => 'required|max:1000',

            ]);

            $is_valid= count($request->section ?? []) > 20 ? false : true;
            $error_message=__('Maximum Section Limit Is 20');

            if ($is_valid == false) {
                return response()->json([
                    'message' => $error_message,
                ], 403);
            }



            foreach ($request->section as $key => $section) {
            
               if (count($section['value'] ?? []) == 0) {
                   $is_valid=false;
                   $error_message=__('Fill up the list option value');

                   break;
               }
               elseif ($section['title'] == null || !$section['title']) {
                   $is_valid=false;
                   $error_message=__('Fill up all the title field');

                   break;
               }
               elseif (strlen($section['title']) > 50) {
                   $is_valid=false;
                   $error_message=__('Maximum title limit is 50');

                   break;
               }
               else{
                foreach ($section['value'] as $value_key => $value) {
                    if (empty($value['title'])) {
                     $is_valid=false;
                     $error_message=__('Option title is required');

                     break;
                    }
                    elseif (strlen($value['title']) > 50) {
                     $is_valid=false;
                     $error_message=__('List value name maximum word limit is 50');

                     break;
                    }
                    elseif (strlen($value['description']) > 50) {
                        $is_valid=false;
                        $error_message=__('List value description maximum word limit is 50');

                        break;
                    }
                }
               }
            }

            if ($is_valid == false) {
                return response()->json([
                    'message' => $error_message,
                ], 403);
            }
        }


        $template=$this->saveTemplate($request->all(), $request->message,$type,Auth::id(),$id);
       
        return response()->json([
            'message' => __('Template Updated Successfully..!!'),
        ], 200);
    }

    public function destroy($id)
    {
        $template=Template::where('user_id',Auth::id())->findorFail($id);
        if ($template->type == 'text-with-media') {
            $file='';

            if (isset($template->body['image'])) {
                $file=$template->body['image']['url'];
            }
            elseif (isset($template->body['attachment'])) {
               $file=$template->body['attachment']['url'];
            }

           

            if ($file != '') {
                $fileArr=explode('uploads', $file);
                if (isset($fileArr[1])) {
                   $file='uploads'.$fileArr[1];
                   if (Storage::exists($file)) {
                      Storage::delete($file);
                   }
                   
                }
            }
        }
        $template->delete();

        return response()->json([
            'message'  => __('Template deleted successfully..!!'),
            'redirect' =>  route('user.template.index')
        ], 200);

    }

}
