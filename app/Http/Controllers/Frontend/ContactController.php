<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Mail;
use Session;
use App\Traits\Seo;
class ContactController extends Controller
{
    use Seo;
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->metadata('seo_contact');
        $contact_page= get_option('contact-page',true);

        return view('frontend.contact',compact('contact_page'));
    }

    /**
     * Send email to the admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendMail(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => ['required', 'string','max:20'],
            'email'    => 'required|email|max:40',
            'phone'    => 'required|max:15',
            'subject'    => 'required|max:100',
            'message'    => 'required|max:500',
        ]);


      try {

           $data['name']    = $request->name;
           $data['email']   = $request->email;
           $data['phone']   = $request->phone;
           $data['subject'] = $request->subject;
           $data['message'] = $request->message;

           env('QUEUE_MAIL') == true ? Mail::to(env('MAIL_TO'))->queue(new ContactMail($data)) : Mail::to(env('MAIL_TO'))->send(new ContactMail($data));
           
           Session::flash('success',__('Thanks for contact with us we will contact you soon'));

           return back();
      } catch (Exception $e) {
          Session::flash('error',__('Something wrong'));

          return back();
      } 
    }
}
