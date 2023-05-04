@extends('frontend.layouts.main')
@section('content')
@include('frontend.layouts.header-2')
<main>
   <!-- breadcrumb area start -->
   <div class="breadcrumb__area breadcrumb-height p-relative grey-bg"
   data-background="{{ asset('assets/frontend/img/breadcrumb/breadcrumb.jpg') }}">
   <div class="breadcrumb__scroll-bottom smooth">
      <a href="#faq">
         <i class="far fa-arrow-down"></i>
      </a>
   </div>
   <div class="container">
      <div class="row">
         <div class="col-xxl-12">
            <div class="breadcrumb__content text-center">
               <h3 class="breadcrumb__title">{{ $page->title }}</h3>
               <div class="breadcrumb__list">
                  <span><a href="{{ url('/') }}">{{ __('Home') }}</a></span>
                  <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                  <span>{{ $page->title }}</span>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- breadcrumb area end -->
<div class="postbox__area pt-120 pb-120">
   <div class="container">
      <div class="row">
         <div class="col-xxl-12 col-xl-12 col-lg-12 col-12">
            <div id="Blog-Details" class="postbox__wrapper postbox__p-right">
               <article class="postbox__item format-image transition-3">
                  <div class="postbox__content">                    
                     <h3 class="postbox__title text-center">
                        {{ $page->title }}
                     </h3>                    
                     <div class="postbox__thumb2 mb-60">
                        <div class="postbox__text text-justify">
                           <p class="text-justify">{!!  filterXss($page->description->value ?? '') !!}</p>
                        </div>
                     </div>                     
                  </div>
               </article>              
            </div>
         </div>        
      </div>
   </div>
</div>
</main>
@endsection