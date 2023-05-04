<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Session;
class SaasMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('user/subscription*') || $request->is('user/dashboard*') || $request->is('user/support*') || $request->is('user/profile*') || $request->is('user/make-subscribe/*')) {
           
            return $next($request);
        }

        

        if (Auth::user()->will_expire == null) {
           
            Session::flash('saas_error',__('Your subscription payment is not completed'));
            $redirect_url = Auth::user()->plan_id == null ? '/user/subscription' : '/user/subscription/'.Auth::user()->plan_id;

           return redirect($redirect_url);
          
        }

        if (Auth::user()->will_expire < now()) {

            Session::flash('saas_error',__('Your subscription payment was expired please renew the subscription'));

            return redirect('/user/dashboard');
        }


         return $next($request);
        
    }
}
