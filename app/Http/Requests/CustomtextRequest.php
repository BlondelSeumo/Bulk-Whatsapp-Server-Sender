<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CustomtextRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request,$type)
    {
        dd($type);
        $erros= [
            'phone'   => ['required', new Phone],
            'device'=>['required','numeric'], 
        ];

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

        return $erros;
    }
}
