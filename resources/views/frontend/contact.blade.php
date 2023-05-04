@extends('frontend.layouts.main')
@section('content')
@include('frontend.layouts.header-2')
   <main>
      <!-- breadcrumb area start -->
      <div class="breadcrumb__area breadcrumb-height p-relative grey-bg"
         data-background="{{ asset('assets/frontend/img/breadcrumb/breadcrumb.jpg') }}">
         <div class="breadcrumb__scroll-bottom smooth">
            <a href="#contact">
               <i class="far fa-arrow-down"></i>
            </a>
         </div>
         <div class="container">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="breadcrumb__content text-center">
                     <h3 class="breadcrumb__title">{{ __('Contact us') }}</h3>
                     <div class="breadcrumb__list">
                        <span><a href="{{ url('/') }}">{{ __('Home') }}</a></span>
                        <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                        <span>{{ __('Contact us') }}</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- breadcrumb area end -->

      <!-- contact area start -->
      <div class="tp-conatact-area pt-125 pb-125">
         <div class="container">
            <div class="row">
               <div class="col-xl-4 col-lg-4 col-md-4 mb-30">
                  <div class="contact-info text-center">
                     <span class="contact-icon"><i class="fas fa-map-marker-alt"></i></span>
                     <h4>{{ __('Visit Us Daily') }}</h4>
                     <span>
                        <a href="{{ $contact_page->map_link ?? '' }}" target="_blank">{{ $contact_page->address ?? '' }}<br>{{ $contact_page->country ?? '' }}</a>
                     </span>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-4 mb-30">
                  <div class="contact-info text-center">
                     <span class="contact-icon"><i class="fas fa-phone-volume"></i></span>
                     <h4>{{ __('Contact Us') }}</h4>
                     <span>
                        <a href="tel:{{ $contact_page->contact1 ?? '' }}">{{ $contact_page->contact1 ?? '' }}<br>
                          {{ $contact_page->contact2 ?? '' }}</a>
                     </span>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-4 mb-30">
                  <div class="contact-info text-center">
                     <span class="contact-icon"><i class="fas fa-envelope"></i></span>
                     <h4>{{ __('Email Us') }}</h4>
                     <span><a href="mailto:{{ $contact_page->email1 ?? '' }}">{{ $contact_page->email1 ?? '' }}</a><br>
                        <a href="mailto:{{ $contact_page->email2 ?? '' }}">{{ $contact_page->email2 ?? '' }}</a></span>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xl-12">
                  <div id="contact" class="contact-form-box pt-60">
                     <div class="contact-form-box text-center">
                        <div class="row justify-content-center">
                           <div class="col-8">
                              <h4 class="contact-title">{{ __('Send us a Message :') }}</h4>
                           </div>
                        </div>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                         <ul>
                           @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                           @endforeach
                        </ul>
                       </div>
                       @endif
                       @if(Session::has('success'))                       
                       <div class="alert alert-success" role="alert">
                         {{ Session::get('success') }}
                       </div>
                       @endif
                       @if(Session::has('error'))                       
                       <div class="alert alert-danger" role="alert">
                         {{ Session::get('error') }}
                       </div>
                       @endif
                        <form action="{{ route('send.mail') }}" method="post">
                           @csrf
                           <div class="row">
                              <div class="col-lg-6 col-md-6 col-12">
                                 <div class="tp-contact-input">
                                    <input type="text" required="" name="name" maxlength="20" placeholder="{{ __('Enter your Name') }}" class="@error('name') is-invalid @enderror">
                                 </div>                               
                              </div>
                              <div class="col-lg-6 col-md-6 col-12">
                                 <div class="tp-contact-input">
                                    <input type="email" required="" name="email" maxlength="40" placeholder="{{ __('Enter your Mail') }}" class="@error('email') is-invalid @enderror">
                                 </div>
                                 
                              </div>
                              <div class="col-lg-6 col-md-6 col-12">
                                 <div class="tp-contact-input">
                                    <input type="number" required="" name="phone" maxlength="15" placeholder="{{ __('Enter your Number') }}" class="@error('phone') is-invalid @enderror">
                                 </div>                                
                              </div>
                              <div class="col-lg-6 col-md-6 col-12">
                                 <div class="tp-contact-input">
                                    <input type="text" placeholder="{{ __('Subject') }}" maxlength="100" required="" name="subject" class="@error('subject') is-invalid @enderror">
                                 </div>                                
                              </div>
                              <div class="col-12">
                                 <div class="tp-contact-input">
                                    <textarea placeholder="{{ __('Type your Message') }}" maxlength="500" required="" name="message" class="@error('message') is-invalid @enderror"></textarea>
                                 </div>                                
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-12">
                                 <div class="tp-submit-button">
                                    <button type="submit" class="tp-btn-blue-square"><span>{{ __('Send Message') }}</span></button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- contact area end -->
   </main>
@endsection