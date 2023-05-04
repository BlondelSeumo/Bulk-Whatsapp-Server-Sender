@extends('frontend.layouts.main')
@section('content')
@include('frontend.layouts.header-2')
<main>
      <!-- breadcrumb area start -->
      <div class="breadcrumb__area breadcrumb-height p-relative grey-bg"
         data-background="{{ asset('assets/frontend/img/breadcrumb/breadcrumb.jpg') }}">
         <div class="breadcrumb__scroll-bottom smooth">
            <a href="#service-inner__process-box">
               <i class="far fa-arrow-down"></i>
            </a>
         </div>
         <div class="container">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="breadcrumb__content text-center">
                     <h3 class="breadcrumb__title">{{ $feature->title }}</h3>
                     <div class="breadcrumb__list">
                        <span><a href="{{ url('/') }}">{{ __('Home') }}</a></span>
                        <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                        <span>{{ $feature->title }}</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- breadcrumb area end -->

      <!-- service-inner-area-start -->
      <div class="service-inner__area pt-130 pb-110">
         <div class="container">
            <div class="row">
               <div class="col-xl-12  col-lg-12  col-md-12  col-sm-12 mb-30">
                  <div class="service-inner__top-thumb text-center">
                     <img src="{{ asset($feature->banner->value ?? '') }}" alt="">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-12">
                  <div id="service-inner__process-box" class="service-inner__process-box">
                     <h3 class="service-inner__title">{{ $feature->title }}</h3>
                     <p>{{ $feature->excerpt->value ?? '' }}</p>
                  </div>               
                  <div class="service-inner__process-box">                     
                     <p>{{ $feature->longDescription->value ?? '' }}</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- service-inner-area-end -->

      <!-- tp-price-area-start -->
     @include('frontend.pricings')
      <!-- tp-price-area-end -->
   </main>
@endsection