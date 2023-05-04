@extends('frontend.layouts.main')
@section('content')
@include('frontend.layouts.header-1')
<!-- tp-offcanvus-area-start -->
<div class="body-overlay"></div>
<main>
      @include('frontend.sections.hero-1')

      @if($features_area == 'active')
       <!-- tp-feature-area-start -->
       <div id="feature-area" class="tp-feature__area pt-60 pb-100">
         <div class="container">
            <div class="row">
               <div class="col-12">
                  <div class="tp-feature__section-box text-center mb-70">
                     <h3 class="tp-section-title wow tpfadeUp" data-wow-duration=".7s" data-wow-delay=".3s">{{ $home->features->title ?? '' }}</h3>
                  </div>
               </div>
            </div>
            <div class="row">
               @include('frontend.sections.features',['limit'=> 6])
            </div>
         </div>
      </div>
      <!-- tp-feature-area-end -->
      @endif

      <!-- tp-appliction-area-start -->
       @include('frontend.sections.top-area')
      <!-- tp-appliction-area-end -->


      <!-- tp-faq-area-end -->
      @include('frontend.sections.top-faq')
      <!-- tp-faq-area-end -->


      <!-- tp-Integration-area-start -->
      @include('frontend.sections.top-integration')
      <!-- tp-Integration-area-end -->
      @include('frontend.pricings')
      <!-- tp-testimonial-area-start -->
      @include('frontend.sections.feedback-1')
      <!-- tp-testimonial-area-end -->

      <!-- tp-choose-area-start -->
       @include('frontend.whychoose')
      <!-- tp-choose-area-end -->


      <!-- tp-support-area-start -->
      @include('frontend.sections.faq')
      <!-- tp-support-area-end -->


   </main>
@endsection
