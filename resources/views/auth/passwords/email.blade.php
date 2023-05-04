@extends('frontend.layouts.main')
@section('content')
@include('frontend.layouts.header-2')
<main>
      <!-- breadcrumb area start -->
      <div class="breadcrumb__area breadcrumb-height p-relative grey-bg"
         data-background="{{ asset('frontend/img/breadcrumb/breadcrumb.jpg') }}">
         <div class="breadcrumb__scroll-bottom smooth">
            <a href="#login">
               <i class="far fa-arrow-down"></i>
            </a>
         </div>
         <div class="container">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="breadcrumb__content text-center">
                     <h3 class="breadcrumb__title">{{ __('Reset Password') }}</h3>
                     <div class="breadcrumb__list">
                        <span><a href="{{ url('/') }}">{{ __('Home') }}</a></span>
                        <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                        <span>{{ __('Reset Password') }}</span>
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
                     <img src="{{ asset('frontend/img/contact/login.jpg') }}" alt="">
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 col-12">
                  <div class="tp-login-wrapper login-space d-flex justify-content-center">
                     <div id="login" class="tplogin">
                        <div class="tplogin__title">
                           <h3 class="tp-login-title">{{ __('Reset Password') }}</h3>
                        </div>
                        <div class="tplogin__form">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif
                          <form method="POST" action="{{ route('password.email') }}">
                             @csrf
                              <div class="tp-mail">
                                 <label for="mail">{{ __('Email Address') }}</label>
                                  <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                              
                             
                              <div class="tp-login-button">
                                 <button class="tp-btn-blue-square w-100" type="submit"><span>{{ __('Send Password Reset Link') }}</span></button>
                              </div>
                              
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </main>
@endsection
