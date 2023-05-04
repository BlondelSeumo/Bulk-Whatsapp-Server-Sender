<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Smstransaction;
use App\Models\Device;
use App\Models\Template;
use App\Rules\Phone;
use App\Traits\Whatsapp;
use Http;
use Auth;
use File;
class CustomTextController extends Controller
{

    use Whatsapp;

    //return custom text message view page
    public function index()
    {
       
        $phoneCodes=file_exists('uploads/phonecode.json') ? json_decode(file_get_contents('uploads/phonecode.json')) : [];
        $devices=Device::where('user_id',Auth::id())->where('status',1)->latest()->get();
        return view('user.singlesend.create',compact('phoneCodes','devices'));
    }

    //sent custom text msg request to api
    public function sentCustomText(Request $request,$type)
    {
       

        $validated = $request->validate([
            'phone'   => ['required', new Phone],
            'device'=>['required','numeric'], 
        ]);

        if (getUserPlanData('messages_limit') == false) {
            return response()->json([
                'message'=>__('Maximum Monthly Messages Limit Exceeded')
            ],401);  
        }

        if ($request->templatestatus) {
            if (getUserPlanData('template_limit') == false) {
                return response()->json([
                    'message'=>__('Maximum Template Limit Exceeded')
                ],401);  
            }
        }

        $device=Device::where('user_id',Auth::id())->where('status',1)->findorFail($request->device);

        $phone=str_replace('+', '', $request->phone);

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

       

       

        if ($request->templatestatus) {
            $validated = $request->validate([
                'template_name' => 'required|max:100',
            ]);

           $template=$this->saveTemplate($request->all(), $request->message,$type,Auth::id());
           if ($template == false) {
               return response()->json([
                    'message' => __('Maximum Template Limit Exceeded'),
                ], 403);
           }
        }

        
       

        $whatsapp= $this->messageSend($request->all(),$device->id,$phone,$type);

        if ($whatsapp['status'] != 200) {
            return response()->json([
                    'message' => $whatsapp['message'],
                ], $whatsapp['status']);
        }

        else{
           $logs['user_id']=Auth::id();
           $logs['device_id']=$device->id;
           $logs['from']=$device->phone;
           $logs['to']=$phone;
           $logs['type']='single-send';

           $this->saveLog($logs);
           
           return response()->json([
                    'message' => __('Message sent successfully..!!'),
                ], 200);
        }           

    }

    //creating record
    public function createTransaction($arr)
    {
         $trans=new Smstransaction;
         foreach ($arr as $key => $value) {
             $trans->$key=$value;
         }
         $trans->save();
    }



}
