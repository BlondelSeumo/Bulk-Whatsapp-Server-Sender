<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedulemessage;
use Carbon\Carbon;
use App\Models\Schedulecontact;
use App\Models\User;
use App\Models\Device;
use App\Traits\Whatsapp;
use App\Traits\Notifications;
class CronController extends Controller
{
    use Whatsapp;
    use Notifications;


     /**
     * execute shedule
     *
     * @return \Illuminate\Http\Response
     */
    public function ExecuteSchedule()
    {
      $today=Carbon::today()->toDateString();

      $schedulemessages=Schedulemessage::whereHas('contacts')->whereHas('device')->whereHas('user')->with('contacts','device','user','template')->where('date','<=',$today)->where('status','pending')->get();
      
    

      foreach ($schedulemessages as $key => $schedulemessage) {

            $schedule=Schedulemessage::where('id',$schedulemessage->id)->first();

            $response = $this->sentRequest($schedulemessage);
            if ($response == 200) {
                $schedule->status='delivered';
            }
            else{
                $schedule->status='rejected';
            }

            $schedule->save();       
      }

       return "Cron job executed";
    }


     /**
     * notify to subscribers before expire the subscription
     */
    public function sentRequest($data)
    {
        if (!empty($data->template)) {
           $template = $data->template;

           if (isset($template->body['text'])) {
            $body = $template->body;
            $user=$data->user;

            $text=$this->formatText($template->body['text'],[],$user);
            $body['text'] = $text;
           }
           else{
            
            $body = $template->body;
            
           }

           $type = $template->type;
           $logs['template_id']=$data->template_id;
        }
        else{
            
            $body = array('text'=>$data->body);
            $type = 'plain-text';
        }
        
        $device_id=$data->device_id;
        $from = $data->device->phone;
        $status=null;

        foreach ($data->contacts as $key => $contact) {
            try {

                if ($type == 'plain-text') {
                    $response= $this->messageSend($body,$device_id,$contact->phone,$type,true,0);
                }
                else{
                    if (isset($body['text'])) {
                        $text=$this->formatText($body['text'],$contact);
                        $body['text'] = $text;
                        $message = $body;
                    }
                    else{
                        $message = $body;
                    }

                    $response= $this->messageSend($message,$device_id,$contact->phone,$type,true,0);
                }

                if ($response['status'] == 200) {
                    $logs['user_id']=$data->user_id;
                    $logs['device_id']=$device_id;
                    $logs['from']=$from;
                    $logs['to']=$contact->phone;
                    $logs['type']='schedule-message';
                    $this->saveLog($logs);
                }


                $status=200;
            } catch (Exception $e) {
                $status=500;
            }
        }

        return $status;
    }


    /**
     * notify to subscribers before expire the subscription
     *
     * @return \Illuminate\Http\Response
     */
    public function notifyToUser()
    {
       $willExpire = today()->addDays(7)->format('Y-m-d');
       $users = User::whereHas('subscription')->with('subscription')->where('will_expire',$willExpire)->latest()->get();

       foreach ($users as $key => $user) {
           $this->sentWillExpireEmail($user);
       }

       return "Cron job executed";
    }

    /**
     * remove junk devices
     *
     * @return \Illuminate\Http\Response
     */
    public function removeJunkDevice()
    {
        $subdays = today()->subDays(7);
        $devices = Device::where('phone',null)->where('created_at',$subdays)->delete();

        return "Cron job executed";
    }

}
