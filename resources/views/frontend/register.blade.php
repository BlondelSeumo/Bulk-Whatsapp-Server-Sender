@extends('frontend.layouts.main')
@section('content')
@include('frontend.layouts.header-2')
<main>
      <!-- breadcrumb area start -->
      <div class="breadcrumb__area breadcrumb-height p-relative grey-bg"
         data-background="{{ asset('assets/frontend/img/breadcrumb/breadcrumb.jpg') }}">
         <div class="breadcrumb__scroll-bottom smooth">
            <a href="#login">
               <i class="far fa-arrow-down"></i>
            </a>
         </div>
         <div class="container">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="breadcrumb__content text-center">
                     <h3 class="breadcrumb__title">{{ __('Register with '.$plan->title) }}</h3>
                     <div class="breadcrumb__list">
                        <span><a href="{{ url('/') }}">{{ __('Home') }}</a></span>
                        <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                        <span>{{ __('Lets work together') }}</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- breadcrumb area end -->

        <!--login-area-start -->
      <div class="tp-login-area">
         <div class="container-fluid p-0">
            <div class="row gx-0 align-items-center">
               <div class="col-xl-6 col-lg-6 col-12">
                  <div class="tp-login-thumb login-space sky-bg d-flex justify-content-center">
                     <img src="{{ asset('assets/frontend/img/contact/login.jpg') }}" alt="">
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 col-12">
                  <div class="tp-login-wrapper login-space d-flex justify-content-center">
                     <div id="login" class="tplogin">
                        <div class="tplogin__title">
                           <h3 class="tp-login-title">{{ __('Register your Account') }}</h3>
                        </div>
                        <div class="tplogin__form">
                          <form method="POST" action="{{ url('register-plan',$plan->id) }}">
                            @csrf
                             <div class="tp-mail">
                                 <label for="name">{{ __('Your Name') }}</label>
                                  <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                              <div class="tp-mail">
                                 <label for="mail">{{ __('Email Address') }}</label>
                                  <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ $request->email ??  old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                              <div class="tp-password">
                                 <label for="Password">{{ __('Password') }}</label>
                                 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                             
                              <div class="tp-login-button">
                                 <button class="tp-btn-blue-square w-100" type="submit"><span>{{ __('Sign Up') }}</span></button>
                              </div>
                              <div class="tp-signup d-flex justify-content-between">
                                 <div class="account">
                                    <a href="{{ url('/login') }}">{{ __('have an account?') }}</a>
                                 </div>
                                 <div class="signin">
                                    <a href="{{ url('/login') }}">{{ __('Sign in now') }}</a>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- login-area-end -->

   </main>

@endsection
