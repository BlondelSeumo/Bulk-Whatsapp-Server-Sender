<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Plan;
use App\Models\User;
use Hash;
use Str;
use Auth;
use App\Traits\Seo;
use Session;
class PricingController extends Controller
{

    use Seo;

    /**
     * Display a pricing page of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Post::where('type','faq')->where('featured',1)->where('lang',app()->getLocale())->with('excerpt')->latest()->get();
        $plans = Plan::where('status',1)->latest()->get();

        $this->metadata('seo_pricing');

        return view('frontend.plans',compact('faqs','plans'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @param  Request 
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request, $id)
    {
        $plan = Plan::where('status',1)->findorFail($id);

        $meta['title'] = $plan->title ?? '';
        $this->pageMetaData($meta);


        return view('frontend.register',compact('plan','request'));
    }


    /**
     * register a user with plan
     *
     * @param  integer  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerPlan(Request $request, $id)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $plan = Plan::where('status',1)->findorFail($id);

        $user              = new User;
        $user->name        = $request->name;
        $user->email       = $request->email;
        $user->role        = 'user';
        $user->status      = 1;
        $user->plan        = json_encode($plan->data);
        $user->plan_id     = $plan->id;
        $user->will_expire = $plan->is_trial == 1 ? now()->addDays($plan->days) : null;
        $user->authkey     = $this->generateAuthKey();
        $user->password    = Hash::make($request->password);
        $user->save();

        Auth::login($user);

        if ($user->will_expire == null) {
            return redirect('user/subscription/'.$plan->id);
        }

        Session::put('new-user',__('Lets create a whatsapp device'));
        return redirect('/user/device/create');

    }

    /**
     * generate auth key
     */
    public function generateAuthKey()
    {
        $rend = Str::random(50);
        $check = User::where('authkey', $rend)->first();

        if($check == true){
            $rend = $this->generateAuthKey();
        }
        return $rend;
    }
}
