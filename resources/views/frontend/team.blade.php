@extends('frontend.layouts.main')
@section('content')
@include('frontend.layouts.header-2')
<main>
   <!-- breadcrumb area start -->
   <div class="breadcrumb__area breadcrumb-height p-relative grey-bg"
      data-background="{{ asset('assets/frontend/img/breadcrumb/breadcrumb.jpg') }}">
      <div class="breadcrumb__scroll-bottom smooth">
         <a href="#team">
         <i class="far fa-arrow-down"></i>
         </a>
      </div>
      <div class="container">
         <div class="row">
            <div class="col-xxl-12">
               <div class="breadcrumb__content text-center">
                  <h3 class="breadcrumb__title">{{ __('Team') }}</h3>
                  <div class="breadcrumb__list">
                     <span><a href="{{ url('/') }}">{{ __('Home') }}</a></span>
                     <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                     <span>{{ __('Our Team') }}</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- breadcrumb area end -->
   <div id="team" class="tp-team__area tp-team__inner p-relative pt-130 pb-70">
      <div class="container">
         <div class="row">
            @foreach($teams as $team)
            <div class="col-xl-3 col-lg-3 col-md-6 mb-70">
               <div class="tp-team__item text-center">
                  <div class="tp-team__img fix">
                     <img src="{{ asset($team['avatar']) }}" alt="">
                  </div>
                  <div class="tp-team__content">
                     <h4 class="tp-team__title"><a href="#">{{ $team['name'] }}</a></h4>
                     <span>{{ $team['position'] }}</span>
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
   <!-- tp-support-area-start -->
   <div class="tp-support__area pt-120 pb-120 grey-bg p-relative">
      <div class="tp-support__bg">
         <img src="{{ asset('assets/frontend/img/faq/faq-bg-shape.png') }}" alt="">
      </div>
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="tp-support__title-box text-center mb-70">
                  <h3 class="tp-section-title">{{ __('Frequently asked questions') }} 📣</h3>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-12">
               <div class="tp-support__faq">
                  <div class="tp-custom-accordio-2">
                     <div class="accordion" id="accordionExample-2">
                       @foreach($faqs as $key => $faq)
                       @if($faq->slug == 'bottom')
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
            </div>
         </div>
      </div>
   </div>
   <!-- tp-support-area-end -->
</main>
@endsection
