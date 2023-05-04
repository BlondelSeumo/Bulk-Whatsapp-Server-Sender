@extends('frontend.layouts.main')
@section('content')
@include('frontend.layouts.header-2')
 <main>
      <!-- breadcrumb area start -->
      <div class="breadcrumb__area breadcrumb-height p-relative grey-bg"
         data-background="{{ asset('assets/frontend/img/breadcrumb/breadcrumb.jpg') }}">
         <div class="breadcrumb__scroll-bottom smooth">
            <a href="#tp-service__area">
               <i class="far fa-arrow-down"></i>
            </a>
         </div>
         <div class="container">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="breadcrumb__content text-center">
                     <h3 class="breadcrumb__title">{{ $about->breadcrumb_title ?? '' }}</h3>
                     <div class="breadcrumb__list">
                        <span><a href="{{ url('/') }}">{{ __('Home') }}</a></span>
                        <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                        <span>{{ __('About us') }}</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- breadcrumb area end -->

      <!-- tp-about-area-start -->
      <div id="about-inner__area" class="about-inner__area pt-130 pb-130">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-lg-9 col-md-12">
                  <div class="about-inner__section-box mb-70 text-center wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                     <span class="about-inner__subtitle">{{ __('About Company') }}</span>
                     <h3 class="tp-section-title-md">{{ $about->section_title ?? '' }}</h3>
                  </div>
               </div>
            </div>
            <div class="row g-0">
               <div class="col-xl-7 col-lg-7">
                  <div class="about-inner__wrapper wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".5s">
                     <div class="row gx-10">
                        <div class="col-xl-6 col-lg-6 col-md-6 mb-20">
                           <div class="about-inner__thumb w-img">
                              <img src="{{ asset($about->about_image_1 ?? '') }}" alt="">
                           </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                           <div class="about-inner__content-item mb-10  d-flex align-items-center">
                              <span>{{ $about->experience ?? '' }}</span>
                              <p>{{ $about->experience_title ?? '' }}</p>
                           </div>
                           <div class="about-inner__thumb-2 w-img mb-20">
                              <img src="{{ asset($about->about_image_2 ?? '') }}" alt="">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-5 col-lg-5 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".7s">
                  <div class="about-inner__right">
                     <div class="about-inner__content">
                     	@foreach($descriptions as $description)
                        <p>{{ $description }}</p>
                        @endforeach
                     </div>
                     <div class="about-inner__list">
                        <ul>
                           @foreach($facilities as $facility)
                            <li><i class="far fa-check"></i> {{ $facility }}</li>
                           @endforeach
                        </ul>
                     </div>
                     <div class="about-inner__btn d-flex align-items-center">
                     	@if(!empty($about->button_title))
                        <a class="tp-btn-blue-square mr-20" href="{{ $about->button_link }}"><span>{{ $about->button_title }}</span></a>
                        @endif

                        @if(!empty($about->introducing_video))
                        <a class="about-inner__play-btn popup-video" href="{{ $about->introducing_video }}"><i class="fas fa-play"></i></a>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- tp-about-area-end -->

      <!-- tp-service-area-start -->
      <div id="tp-service__area" class="tp-service__area tp-service__space service-inner grey-bg pt-120 pb-100">
         <div class="container">
            <div class="row">
               <div class="col-12">
                  <div class="tp-service__section-wrapper service-inner d-flex justify-content-between wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                     <div class="tp-service__title-box ml-40">
                        <h3 class="tp-service__title">{{ __('Our Features') }}
                        </h3>
                     </div>
                     <div class="tp-service__inner-btn">
                        <a class="tp-btn-blue-square" href="{{ url('/features') }}"><span>{{ __('See All Features') }}</span></a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="tp-service__slider-wrapper service-inner">
               <div class="tp-service__slider-active">
                  @foreach($features as $feature)
                  <div class="tp-service__item wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".7s">
                     <div class="tp-service__icon">
                        <img src="{{ asset($feature->preview->value ?? '') }}" alt="">
                     </div> 
                     <div class="tp-service__content">
                        <h4 class="tp-service__title-sm"><a href="{{ url('feature/'.$feature->slug) }}">{{ Str::limit($feature->title,20) }}</a></h4>
                        <p>{{  Str::limit($feature->excerpt->value ?? '',100) }}</p>
                     </div>
                     <div class="tp-service__link">
                        <a href="{{ url('feature/'.$feature->slug) }}">
                           <svg width="39" height="16" viewBox="0 0 39 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M38.7071 8.70711C39.0976 8.31658 39.0976 7.68342 38.7071 7.29289L32.3431 0.928932C31.9526 0.538408 31.3195 0.538408 30.9289 0.928932C30.5384 1.31946 30.5384 1.95262 30.9289 2.34315L36.5858 8L30.9289 13.6569C30.5384 14.0474 30.5384 14.6805 30.9289 15.0711C31.3195 15.4616 31.9526 15.4616 32.3431 15.0711L38.7071 8.70711ZM0 9H38V7H0V9Z" fill="currentColor"/>
                           </svg>
                        </a>
                     </div> 
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
      <!-- tp-service-area-end -->
      <!-- tp-counter-area-start -->
      <div class="tp-counter-2__area tp-counter-2__space counter-inner grey-bg pb-100">
         <div class="container">
            <div class="tp-counter-2__wrapper pt-65">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                     <div class="tp-counter-2__item d-flex align-items-center justify-content-sm-start justify-content-center">
                        <div class="tp-counter-2__icon">
                           <img src="{{ asset('assets/frontend/img/counter/counter-7.png') }}" alt="">
                        </div>
                        <div class="tp-counter-2__content">
                           <h4><span class="counter">{{ $counter->experience ?? '' }}</span>+</h4>
                           <span>{{ __('Years of Experience') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".7s">
                     <div class="tp-counter-2__item d-flex align-items-center justify-content-sm-start justify-content-center">
                        <div class="tp-counter-2__icon">
                           <img src="{{ asset('assets/frontend/img/counter/counter-6.png') }}" alt="">
                        </div>
                        <div class="tp-counter-2__content">
                           <h4><span class="counter">{{ $counter->active_customers ?? '' }}</span>+</h4>
                           <span>{{ __('Active Customers') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".9s">
                     <div class="tp-counter-2__item d-flex align-items-center justify-content-sm-start justify-content-center">
                        <div class="tp-counter-2__icon">
                           <img src="{{ asset('assets/frontend/img/counter/counter-5.png') }}" alt="">
                        </div>
                        <div class="tp-counter-2__content">
                           <h4><span class="counter">{{ $counter->positive_reviews ?? '' }}</span>+</h4>
                           <span>{{ __('Positive Reviews') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay="1s">
                     <div class="tp-counter-2__item d-flex align-items-center justify-content-sm-start justify-content-center">
                        <div class="tp-counter-2__icon">
                           <img src="{{ asset('assets/frontend/img/counter/counter-8.png') }}" alt="">
                        </div>
                        <div class="tp-counter-2__content">
                           <h4><span class="counter">{{  $counter->satisfied_customers ?? '' }}</span>+</h4>
                           <span>{{ __('Satisfied customers') }}</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- tp-counter-area-end -->

      <!-- tp-price-area-start -->
      @include('frontend.pricings')
      <!-- tp-price-area-end -->

      <!-- tp-team-area-start -->
      <div class="tp-team__area p-relative">
         <div class="tp-team__grey-bg grey-bg"></div>
         <div class="tp-team__ml-mr theme-bg-3 pt-120 pb-50">
            <div class="container">
               <div class="row">
                  <div class="col-12 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                     <div class="tp-team__section-box d-flex justify-content-between">
                        <h3 class="tp-section-title-md text-white">{{ __('Meet with our') }} <br> {{ __('team') }}</h3>
                        <div class="tp-team__btn">
                           <a class="tp-btn-pink mb-15" href="{{ url('/team') }}"><span>{{ __('All Team Member') }}</span></a>
                           <a class="tp-btn-sky-sm mb-15 ml-15" href="{{ url('/contact') }}"><span>{{ __('Join our Team') }}</span></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  @foreach($teams as $team)

                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-70 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".6s">
                     <div class="tp-team__item text-center">
                        <div class="tp-team__img fix">
                           <img src="{{ asset($team['avatar'] ?? '') }}" alt="">
                        </div>
                        <div class="tp-team__content">
                           <h4 class="tp-team__title"><a href="javascript:void(0)">{{ $team['name'] ?? '' }}</a></h4>
                           <span>{{ $team['position'] ?? '' }}</span>
                        </div>
                        <div class="tp-team__social">
                          @if(!empty($team['socials']->facebook))
                          <a href="{{ $team['socials']->facebook }}"><i class="fab fa-facebook-f"></i></a>
                          @endif
                          @if(!empty($team['socials']->twitter))
                          <a href="{{ $team['socials']->twitter }}"><i class="fab fa-twitter"></i></a>
                          @endif
                          @if(!empty($team['socials']->linkedin))
                          <a href="{{ $team['socials']->linkedin }}"><i class="fab fa-linkedin"></i></a>
                          @endif
                          @if(!empty($team['socials']->instagram))
                          <a href="{{ $team['socials']->instagram }}"><i class="fab fa-instagram"></i></a>
                          @endif
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
      <!-- tp-team-area-end -->

      <!-- tp-faq-area-start -->
      <div class="tp-faq__area pt-120 pb-110">
         <div class="container">
            <div class="row">
               <div class="col-xl-7 col-lg-6 wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".7s">
                  <div class="tp-custom-accordio-3">
                     <div class="accordion" id="accordionExample">
                        @foreach($faqs as $key => $faq)
                         @if($faq->slug != 'top')
                        <div class="accordion-items">
                           <h2 class="accordion-header" id="heading-{{ $key+1 }}">
                              <button class="accordion-buttons {{ $key > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse"
                                 data-bs-target="#collapse-{{ $key+1 }}" aria-expanded="{{ $key == 0 ? true : false }}" aria-controls="collapse-1">
                              {{ $faq->title }}
                              </button>
                           </h2>
                           <div id="collapse-{{ $key+1 }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}" aria-labelledby="heading-{{ $key+1 }}"
                              data-bs-parent="#accordionExample-2">
                              <div class="accordion-body">
                                 {{ $faq->excerpt->value ?? '' }}
                              </div>
                           </div>
                        </div>
                        @endif
                       @endforeach
                     </div>
                  </div>
               </div>
               <div class="col-xl-5 col-lg-6 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".9s">
                  <div class="tp-faq__right-side text-center">
                     <div class="tp-faq__icon">
                        <a href="#">
                           <svg width="30" height="29" viewBox="0 0 30 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M5.9542 23.9764L0 29V0H30V23.9764H5.9542Z" fill="#017EFA"/>
                           </svg>
                        </a>
                     </div>
                     <div class="tp-faq__content">
                        <h4 class="tp-faq__faq-sm-title">{{ __('Do you have more questions?') }}</h4>
                        <p>{{ __('faq_description') }}</p>
                        <a href="{{ url('/contact') }}">{{ __('Shoot a Direct Mail') }}</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- tp-faq-area-end -->
   </main>
@endsection