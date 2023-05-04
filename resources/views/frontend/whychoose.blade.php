<!-- tp-choose-area-start -->
<div class="tp-choose__area pt-120 pb-90" data-background="{{ asset('assets/frontend/img/choose/choose-bg.png') }}">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="tp-choose__title-box text-center">
               <h3 class="tp-section-title text-white mb-20">{{ get_option('why-choose',true, true)->title ?? '' }}</h3>
               <h5 class="tp-choose__subtitle text-white">{{ get_option('why-choose',true, true)->subtitle ?? '' }}</h5>
            </div>
            <div class="tp-choose__thumb-box d-flex justify-content-center">
               <div class="tp-choose__thumb-sm">
                  <a href="{{ url(get_option('why-choose',true, true)->left_button_link ?? '') }}"><img src="{{ asset(get_option('why-choose',true, true)->left_button_image ?? '') }}" alt=""></a>
               </div>
               <div class="tp-choose__thumb-sm">
                  <a href="{{ url(get_option('why-choose',true, true)->right_button_link ?? '') }}"><img src="{{ asset(get_option('why-choose',true, true)->right_button_image ?? '') }}" alt=""></a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- tp-choose-area-end -->

<!-- tp-counter-area-start -->
<div class="tp-counter__area">
   <div class="tp-counter__theme-bg"></div>
   <div class="tp-counter__grey-bg"></div>
   <div class="container">
      <div class="row">
         <div class="col-xl-4 col-lg-4">
            <div class="tp-counter__item d-flex">
               <div class="tp-counter__icon">
                  <img src="{{ asset(get_option('why-choose',true, true)->left_block_image ?? '') }}" alt="">
               </div>
               <div class="tp-counter__content">
                  <span><i class="counter">{{ get_option('why-choose',true, true)->left_block_value ?? '' }}</i></span>
                  <p>{{ get_option('why-choose',true, true)->left_block_title ?? '' }}</p>
               </div>
            </div>
         </div>
         <div class="col-xl-4 col-lg-4">
            <div class="tp-counter__item d-flex">
               <div class="tp-counter__icon">
                  <img src="{{ asset(get_option('why-choose',true, true)->center_block_image ?? '') }}" alt="">
               </div>
               <div class="tp-counter__content">
                  <span><i class="counter">{{ get_option('why-choose',true, true)->center_block_value ?? '' }}</i></span>
                  <p>{{ get_option('why-choose',true, true)->center_block_title ?? '' }}</p>
               </div>
            </div>
         </div>
         <div class="col-xl-4 col-lg-4">
            <div class="tp-counter__item d-flex">
               <div class="tp-counter__icon">
                  <img src="{{ asset(get_option('why-choose',true, true)->right_block_image ?? '') }}" alt="">
               </div>
               <div class="tp-counter__content">
                  <span><i class="counter">{{ get_option('why-choose',true, true)->right_block_value ?? '' }}</i></span>
                  <p>{{ get_option('why-choose',true, true)->right_block_title ?? '' }}</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- tp-counter-area-end -->