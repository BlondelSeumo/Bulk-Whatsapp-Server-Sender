<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Device;
use App\Models\Template;
use App\Models\Smstransaction;
use Http;
trait Whatsapp
{
    private function messageSend($data,$from, $reciver,$type,$filter=false,$delay = 0)
    {
        
        $device=Device::where('status',1)->where('id',$from)->first();
        if (empty($device)) {
            return false;
        }

        //creating session id
        $session_id='device_'.$from;
        
        //formating message     
        $message=$this->formatBody($data['message'] ?? '',$device->user_id);
        
        //formating array context
        $formatedBody= $filter == false ? $this->formatArray($data,$message,$type) : $data;
        
        //get server url
        $whatsServer=env('WA_SERVER_URL');
        
        //formating array before sending data to server
        $body['receiver']=$reciver;
        $body['delay']=$delay;
        $body['message']=$formatedBody;
         
        //sending data to whatsapp server       
        try {
            $response=Http::post($whatsServer.'/chats/send?id='.$session_id,$body);
            $status=$response->status();

            if ($status != 200) {
                $responseBody=json_decode($response->body());
                $responseData['message']=$responseBody->message;
                $responseData['status']=$status;
            }
            else{
                $responseData['status'] = 200;
            }

            return $responseData;
       } catch (Exception $e) {
           $responseData['status'] = 403;
           return $responseData;
       }

    }

    private function getChats($device_id)
    {
        $session_id='device_'.$device_id;
        $whatsServer=env('WA_SERVER_URL');

        $response=Http::get($whatsServer.'/chats?id='.$session_id);
        $status=$response->status();

        if ($status != 200) {
            $responseBody=json_decode($response->body());
            $responseData['message']=$responseBody->message;
            $responseData['status']=$status;
        }
        else{
            $responseBody  =json_decode($response->body());
            $colllections  = collect($responseBody->data);
            $contacts = $colllections->map(function($item) {
                             $phone = explode('@', $item->id);
                             $data['number'] = $phone[0] ?? null;
                             $data['unread'] = $item->unreadCount ?? 0;
                             $data['timestamp'] = $item->conversationTimestamp ?? 0;
                             return $data;
                        });
            
            $responseData['status'] = 200;
            $responseData['data'] = $contacts;
        }

        return $responseData;

    }

    public function getGroupList($device_id)
    {
        $session_id='device_'.$device_id;
        $whatsServer=env('WA_SERVER_URL');

        $response=Http::get($whatsServer.'/groups?id='.$session_id);
        $status=$response->status();

        if ($status != 200) {
            $responseBody=json_decode($response->body());
            $responseData['message']=$responseBody->message;
            $responseData['status']=$status;
        }
        else{
            $responseBody  =json_decode($response->body());
            $colllections  = collect($responseBody->data);

            $contacts = $colllections->map(function($item) {
                             
                             $data['name'] = $item->name;
                             $data['id'] = $item->id;
                             return $data;
                        });
            
            $responseData['status'] = 200;
            $responseData['data'] = $contacts;
        }

        return $responseData;
    }

    private function sendMessageToGroup($data,$from, $reciver,$type,$filter=false,$delay = 0)
    {
       
        $device=Device::where('status',1)->where('id',$from)->first();
        if (empty($device)) {
            return false;
        }

        //creating session id
        $session_id='device_'.$from;
        
        //formating message     
        $message=$this->formatBody($data['message'] ?? '',$device->user_id);
        
        //formating array context
        $formatedBody= $filter == false ? $this->formatArray($data,$message,$type) : $data;
        
        //get server url
        $whatsServer=env('WA_SERVER_URL');
        
        //formating array before sending data to server
        $body['receiver']=$reciver;
        $body['delay']=$delay;
        $body['message']=$formatedBody;
         
        //sending data to whatsapp server       
        try {
            $response=Http::post($whatsServer.'/groups/send?id='.$session_id,$body);
            $status=$response->status();

            if ($status != 200) {
                $responseBody=json_decode($response->body());
                $responseData['message']=$responseBody->message;
                $responseData['status']=$status;
            }
            else{
                $responseData['status'] = 200;
            }

            return $responseData;
       } catch (Exception $e) {
           $responseData['status'] = 403;
           return $responseData;
       }

    }

    private function formatArray($data,$message,$type)
    {

        if ($type == 'plain-text') {
            $content['text']=$message;
        }
        elseif ($type == 'text-with-media') {
            $content['caption']=$message;
            $explode=explode('.', $data['attachment']);
            $file_type=strtolower(end($explode));
            $extentions=[
                'jpg'=>'image',
                'jpeg'=>'image',
                'png'=>'image',
                'webp'=>'image',
                'pdf'=>'document',
                'docx'=>'document',
                'xlsx'=>'document',
                'csv'=>'document',
                'txt'=>'document'
            ];
            
            $content[$extentions[$file_type]]=['url' => asset($data['attachment'])];
           
        }
        elseif ($type == 'text-with-button') {
            $buttons=[];
            foreach ($data['buttons'] as $key => $button) {
                $button_content['buttonId']='id'.$key;
                $button_content['buttonText']= array('displayText' => $button);
                $button_content['type']=1;

                array_push($buttons, $button_content);
            }


           $content['text']=$message;
           $content['footer']=$data['footer_text'];
           $content['buttons']=$buttons;
           $content['headerType']=1;
        }

        elseif ($type == 'text-with-template') {
             $templateButtons=[];
            foreach ($data['buttons'] as $key => $button) {
                $button_type='';
                $button_action_content='';

                if ($button['type'] == 'urlButton') {
                    $button_type='url';
                    $button_action_content=$button['action'];
                }
                elseif ($button['type'] == 'callButton') {
                    $button_type='phoneNumber';
                    $button_action_content=$button['action'];
                }
                else{
                    $button_type='id';
                    $button_action_content='action-id-'.$key;
                }

                $button_actions=[];
                $button_actions['displayText']=$button['displaytext'];
                $button_actions[$button_type]=$button_action_content;

               

                $button_context['index']=$key;
                $button_context[$button['type']]= $button_actions;

                array_push($templateButtons, $button_context);
                $button_context=null;

            }
          

           $content['text']=$message;
           $content['footer']=$data['footer_text'];
           $content['templateButtons']=$templateButtons;
          
        }
        elseif ($type == 'text-with-location') {
            $content['location']=array(
                'degreesLatitude'=>$data['degreesLatitude'],
                'degreesLongitude'=>$data['degreesLongitude']
            );
        }
        elseif ($type == 'text-with-vcard') {
            $vcard='BEGIN:VCARD\n' // metadata of the contact card
            . 'VERSION:3.0\n' 
            . 'FN:'.$data['full_name'].'\n' // full name
            . 'ORG:'.$data['org_name'].';\n' // the organization of the contact
            . 'TEL;type=CELL;type=VOICE;waid='.$data['contact_number'].':'.$data['wa_number'].'\n' // WhatsApp ID + phone number
            . 'END:VCARD';

           
            $content = [
             "contacts" => [
               "displayName" => "maruf", 
               "contacts" => [[$vcard]] 
             ] 
            ]; 
        }
        elseif ($type == 'text-with-list') {
            
            $templateButtons=[];

            foreach ($data['section'] as $section_key => $sections) {

               $rows=[];

               foreach ($sections['value'] as $value_key => $value) {
                
                   $rowArr['title']=$value['title'];
                   $rowArr['rowId']='option-'.$section_key.'-'.$value_key;

                   if ($value['description'] != null) {
                       $rowArr['description']=$value['description'];
                   }
                   array_push($rows, $rowArr);
                   $rowArr=[];
               }

               $row['title']=$sections['title'];
               $row['rows']=$rows;


              array_push($templateButtons, $row);
              $row=[];
            }
          
             $content = [
               "text" => $message, 
               "footer" =>  $data['footer_text'], 
               "title" => $data['header_title'], 
               "buttonText" =>$data['button_text'], 
               "sections" => $templateButtons
            ]; 
           
           
        }


        return $content;
    }

    private function saveTemplate($data,$message,$type,$user_id,$template_id=null)
    {
       if ($template_id == null) {
          $template= new Template;
       }
       else{
          $template=  Template::findorFail($template_id);
          $template->status=isset($data['status']) ? 1 : 0;
       }
       
       $template->title=$data['template_name'];
       $template->user_id=$user_id;
       $template->body=$this->formatArray($data,$message,$type);
       $template->type=$type;
       $template->save();

       return true;
    }

    private function saveFile(Request $request,$input)
    {
        $file = $request->file($input);
        $ext = $file->extension();
        $filename = now()->timestamp.'.'.$ext;

        $path = 'uploads/message/' . \Auth::id() . date('/y') . '/' . date('m') . '/';
        $filePath = $path.$filename;

       
        Storage::put($filePath, file_get_contents($file));

        return Storage::url($filePath);
    }

    private function formatBody($context='', $user_id)
    {
        if ($context == '') {
            return $context;
        }

        $user=User::where('id',$user_id)->first();

        if (empty($user)) {
           return $context;
        }
        else{
           return $context; 
        }
    }

    private function formatText($context='', $contact_data = null,$senderdata = null)
    {
       if ($context == '') {
            return $context;
       }
       if ($contact_data != null) {
           $name=$contact_data['name'] ?? '';
           $phone=$contact_data['phone'] ?? '';

           $context=str_replace('{name}',$name,$context);
           $context=str_replace('{phone_number}',$phone,$context);

       }

       if ($senderdata != null) {
           $sender_name=$senderdata['name'] ?? '';
           $sender_phone=$senderdata['phone'] ?? '';
           $sender_email=$senderdata['email'] ?? '';

           $context=str_replace('{my_name}',$sender_name,$context);
           $context=str_replace('{my_contact_number}',$sender_phone,$context);
           $context=str_replace('{my_email}',$sender_email,$context);
       }
      
       return $context;


    }

    private function formatCustomText($context='', $replaceableData = [])
    {
        $filteredContent = $context;
        
        foreach ($replaceableData as $key => $value) {
           $filteredContent = str_replace($key, $value, $filteredContent);
        }

        return $filteredContent;

    }

    private function saveLog($data)
    {
        $log= new Smstransaction;
        $log->user_id = $data['user_id'] ?? null;
        $log->device_id = $data['device_id'] ?? null;
        $log->app_id = $data['app_id'] ?? null;
        $log->from = $data['from'] ?? null;
        $log->to = $data['to'] ?? null;
        $log->template_id = $data['template_id'] ?? null;
        $log->type = $data['type'] ?? null;
        $log->save();
    }

}