@extends('frontend.layouts.main')
@section('content')
@include('frontend.layouts.header')
<!-- tp-offcanvus-area-start -->
<div class="body-overlay"></div>
<!-- tp-offcanvus-area-end -->
<main>
    @include('frontend.sections.hero-2')
   <!-- tp-slider-area-end -->
   @if($brand_area == 'active')
   <!-- tp-brand-area-start -->
   <div class="tp-brand__area tp-brand__space pt-130 pb-190">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="tp-brand__section text-center pb-45 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                  <h3 class="tp-brand__title">{{ $home->brand->title ?? '' }}</h3>
               </div>
            </div>
         </div>
         <div class="tp-brand-slide-section">
            <div class="tp-barnd__active">
               @foreach($brands as $brand)
               @if($brand->lang == 'partner')
               <div class="tp-brand__item wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                  <a href="{{ $brand->title }}"><img src="{{ asset($brand->slug) }}" alt=""></a>
               </div>
               @endif
               @endforeach
            </div>
         </div>
      </div>
   </div>
   <!-- tp-brand-area-end -->
   @endif
   <!-- tp-cta-area-start -->
   <div class="tp-cta__area wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
      <div class="container p-relative">
         <div class="tp-cta__thumb">
            <img src="{{ asset($home->cta_thumbnail ?? '') }}" alt="">
         </div>
         <div class="tp-cta__thumb-2 d-none d-lg-block">
            <img src="{{ asset($home->cta_logo ?? '') }}" alt="">
         </div>
         <div class="tp-cta__bg grey-bg">
            <div class="row">
               <div class="col-xl-7 col-lg-8 col-md-12">
                  <div class="tp-cta__item-left">
                     <h3 class="tp-cta__title">{{ $home->cta->title ?? '' }}</h3>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- tp-cta-area-end -->
   @if($features_area == 'active')
   <!-- tp-feature-area-start -->
   <div class="tp-feature__area pt-120 pb-120">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="tp-feature__section text-center mb-70">
                  <h3 class="tp-section-title wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">{{ $home->features->title ?? '' }}</h3>
               </div>
            </div>
         </div>
         <div class="row">
            @include('frontend.sections.features',['limit'=>3])
         </div>
      </div>
   </div>
   <!-- tp-feature-area-end -->
   @endif
   <!-- tp-platform-area-start -->
   <div class="tp-platform__area pb-120">
      <div class="container">
         <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6">
               <div class="tp-platform__wrapper p-relative">
                  <div class="tp-platform__shape-1">
                     <img src="{{ asset('assets/frontend/img/platform/pf-3.png') }}" alt="">
                  </div>
                  <div class="tp-platform__shape-2">
                     <img src="{{ asset('assets/frontend/img/platform/pf-4.png') }}" alt="">
                  </div>
                  <div class="tp-platform__thumb z-index wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".5s">
                     <img src="{{ asset($home->platform_thumbnail ?? '') }}" alt="">
                  </div>
               </div>
            </div>
            <div class="col-xl-6 col-lg-6 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".8s">
               <div class="tp-platform__content pl-40">
                  <h3 class="tp-section-title-sm pb-25">{{ $home->platform->title ?? '' }}</h3>
                  <p class="pb-25">{{ $home->platform->description ?? '' }}</p>
                  <a class="tp-btn-blue" href="{{ url($home->platform->button_link ?? '') }}"><span>{{ $home->platform->button_title ?? '' }}</span></a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- tp-platform-area-end -->
   <!-- tp-price-area-start -->
   @include('frontend.pricings')
   <!-- tp-price-area-end -->
   <!-- tp-account-area-start -->
   <div class="tp-account__area pt-120 pb-120">
      <div class="container">
         <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6 wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".5s">
               <div class="tp-account__wrapper">
                  <div class="tp-account__section-box">
                     <h3 class="tp-section-title-sm pb-20">{{ $home->account_area->heading ?? '' }}</h3>
                     <span>{{ $home->account_area->subheading ?? '' }}</span>
                     <p>{{ $home->account_area->description ?? '' }} </p>
                  </div>
                  <div class="tp-account__form p-relative">
                     <form action="{{ url($home->account_area->form_link ?? '') }}">
                        <div class="tp-account__input">
                           <input type="email" placeholder="example@email.com" name="email">
                        </div>
                        <button>{{ __('sign up') }}<i class="fas fa-paper-plane"></i></button>
                     </form>
                  </div>
                  <div class="tp-account__app-download">
                     <span>{{ __('# Also available mobile apps') }}</span>
                     <div class="tp-account__img-main d-flex">
                        <div class="tp-account__img-1 mr-20">
                           <a href="{{ url($home->account_area->button_link1 ?? '') }}"><img src="{{ asset($home->account_footer_left_image ?? '') }}" alt=""></a>
                        </div>
                        <div class="tp-account__img-2">
                           <a href="{{ url($home->account_area->button_link2 ?? '') }}"><img src="{{ asset($home->account_footer_right_image ?? '') }}" alt=""></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-6 col-lg-6 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".5s">
               <div class="tp-account__thumb-wrapper p-relative">
                  <div class="tp-account__thumb text-center ">
                     <img src="{{ asset($home->account_area_thumbnail ?? '') }}" alt="">
                  </div>
                  <div class="tp-account__sm-img-1 d-none d-md-block">
                     <img src="{{ asset($home->account_area_top_thumbnail ?? '') }}" alt="">
                  </div>
                  <div class="tp-account__sm-img-2 d-none d-md-block">
                     <img src="{{ asset($home->account_area_bottom_thumbnail ?? '') }}" alt="">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- tp-account-area-end -->
   <!-- tp-testimonial-area-start -->
   <div class="tp-testimonial__area grey-bg pt-110 pb-120 fix">
      <div class="container-fluid">
         <div class="row g-0">
            <div class="col-12">
               <div class="tp-testimonial__section text-center pb-50">
                  <h3 class="tp-section-title wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">{{ __('Testimonials') }}</h3>
               </div>
            </div>
         </div>
         <div class="tp-testimonial__section">
            <div class="tp-testimonial__active">
               @foreach($testimonials as $testimonial)
               <div class="tp-testimonial__slider-item d-flex align-items-center p-relative wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                  <div class="tp-testimonial__slider-content">
                     <p>{{ Str::limit($testimonial->excerpt->value ?? '',200) }}</p>
                     <h4 class="tp-testimonial__slider-title">- {{ $testimonial->title ?? '' }}, {{ $testimonial->slug ?? '' }}</h4>
                  </div>
                  <div class="tp-testimonial__slider-img">
                     <img src="{{ asset($testimonial->preview->value ?? '') }}" alt="">
                  </div>
                  <div class="tp-testimonial__slider-quote">
                     <i class="fas fa-quote-left"></i>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
   <!-- tp-testimonial-area-end -->
   <!-- tp-cta-area-start -->
   <div class="tp-cta__area p-relative">
      <div class="tp-cta__grey-bg grey-bg"></div>
      <div class="tp-cta__white-bg white-bg"></div>
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="tp-cta__wrapper-2 theme-bg p-relative">
                  <div class="tp-cta__shape-1">
                     <img src="{{ asset('assets/frontend/img/cta/cta-shape-1.png') }}" alt="">
                  </div>
                  <div class="tp-cta__shape-2">
                     <img src="{{ asset('assets/frontend/img/cta/cta-shape-2.png') }}" alt="">
                  </div>
                  <div class="tp-cta__shape-3">
                     <img src="{{ asset('assets/frontend/img/cta/cta-shape-3.png') }}" alt="">
                  </div>
                  <div class="tp-cta__shape-4">
                     <img src="{{ asset('assets/frontend/img/cta/cta-shape-4.png') }}" alt="">
                  </div>
                  <div class="tp-cta__shape-5">
                     <img src="{{ asset('assets/frontend/img/cta/cta-shape-5.png') }}" alt="">
                  </div>
                  <div class="tp-cta__item text-center">
                     <h3 class="tp-section-title text-white pb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">{{ $home->calltoaction->title ?? '' }}</h3>
                     <a class="tp-btn-sky wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s" href="{{ url($home->calltoaction->button_link ?? '') }}"><span>{{ $home->calltoaction->button_title ?? '' }}</span></a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- tp-cta-area-end -->
   <!-- tp-faq-area-start -->
   <div class="tp-faq__area pt-120 pb-110">
      <div class="container">
         <div class="row">
            <div class="col-xl-7 col-lg-6">
               <div class="tp-custom-accordio-3">
                  <div class="accordion" id="accordionExample">
                     @foreach($faqs as $key => $faq)
                     @if($faq->slug == 'bottom')
                     <div class="accordion-items wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                        <h2 class="accordion-header" id="headingOne">
                           <button class="accordion-buttons {{ $key > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse"
                              data-bs-target="#collapseOne{{ $key }}" aria-expanded="{{ $key == 0 ? true : false }}" aria-controls="collapseOne">
                           {{ $faq->title }}
                           </button>
                        </h2>
                        <div id="collapseOne{{ $key }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                           aria-labelledby="headingOne" data-bs-parent="#accordionExample">
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
            <div class="col-xl-5 col-lg-6 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".9s">
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
                     <a class="w-100" href="{{ url('/contact') }}">{{ __('Shoot a Direct Mail') }}</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- tp-faq-area-end -->
</main>
@endsection
