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
                     <h3 class="breadcrumb__title">{{ __('Our Features') }}</h3>
                     <div class="breadcrumb__list">
                        <span><a href="{{ url('/') }}">{{ __('Home') }}</a></span>
                        <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                        <span>{{ __('Services') }}</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- breadcrumb area end -->

      <!-- tp-service-area-start -->
      <div id="tp-service__area" class="tp-service__area pt-120 pb-90">
         <div class="container">
            <div class="row gx-20">
               @foreach($features as $feature)
               <div class="col-xl-4 col-lg-4 col-md-6 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                  <div class="tp-service__item tp-service__inner-item service-inner mb-20">
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
               </div>
               @endforeach
            </div>
         </div>
      </div>
      <!-- tp-service-area-end -->

       @include('frontend.whychoose')


      <!-- tp-support-area-start -->
      <div class="tp-support__area pt-120 pb-120 grey-bg p-relative">
         <div class="tp-support__bg">
            <img src="{{ asset('assets/frontend/img/faq/faq-bg-shape.png') }}" alt="">
         </div>
         <div class="container">
            <div class="row">
               <div class="col-12">
                  <div class="tp-support__title-box text-center mb-70">
                     <h3 class="tp-section-title">{{ __('Need A Support?') }} 🎧</h3>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-12">
                  <div class="tp-support__faq">
                     <div class="tp-custom-accordio-2">
                        <div class="accordion" id="accordionExample-2">
                           @foreach($faqs as $key => $faq)
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
                       @endforeach
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- tp-support-area-end -->
   </main>
@endsection