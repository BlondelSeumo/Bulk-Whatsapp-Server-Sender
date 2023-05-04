<div class="tp-header-bg">
      <img src="{{ asset('assets/frontend/img/hero/hero-bg-2.png') }}" alt="">
   </div>
   <!-- tp-slider-area-start -->
   <div class="tp-hero__area tp-hero__bg-2">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-xl-9 col-12">
               <div class="tp-hero__wrapper text-center">
                  <div class="tp-hero__content text-center">
                     <h2 class="tp-hero__title-lg pb-40 theme-color wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                        {!! filterXss($heading) !!}                        
                     </h2>
                  </div>
                  <div class="tp-app__download pb-40 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                     <div class="tp-app__thumb-sm d-flex justify-content-center">
                        <div class="tp-app__thumb-sm-1">
                           <a href="{{ $home->heading->left_button_link ?? '#' }}"><img src="{{ asset($home->left_button_image ?? '') }}" alt=""></a>
                        </div>
                        <div class="tp-app__thumb-sm-2">
                           <a href="{{ $home->heading->right_button_link ?? '#' }}"><img src="{{ asset($home->right_button_image ?? '') }}" alt=""></a>
                        </div>
                     </div>
                  </div>
                  <div class="tp-hero__contact pb-70 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".7s">
                     <a href="{{ url('/contact') }}">{{ __('Have a query?') }} <b>{{ __('Contact us') }}</b></a>
                  </div>
                  <div class="tp-hero__thumb-2 p-relative">
                     <img class="wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".9s" src="{{ asset($home->hero_image ?? '') }}" alt="">
                     <div class="tp-hero__img-1 d-none d-lg-block">
                        <img src="{{ asset($home->hero_left_image ?? '') }}" alt="">
                     </div>
                     <div class="tp-hero__img-2 d-none d-lg-block">
                        <img src="{{ asset($home->hero_right_image ?? '') }}" alt="">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>