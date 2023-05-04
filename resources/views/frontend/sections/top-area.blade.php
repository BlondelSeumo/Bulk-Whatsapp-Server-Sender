 <div class="tp-app__area  pt-120 pb-120">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-xl-6 col-lg-6 wow tpfadeLeft" data-wow-duration=".7s" data-wow-delay=".5s">
                  <div class="tp-app__thumb">
                     <img src="{{ asset($home->about_cover ?? '') }}" alt="">
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 wow tpfadeRight" data-wow-duration=".7s" data-wow-delay=".7s">
                  <div class="tp-app__wrapper">
                     <div class="tp-app__content">
                        <h3 class="tp-section-title mb-30">{{ $home->about->title ?? '' }}
                        </h3>
                        <p class="text-dark">{{ $home->about->description ?? '' }}</p>
                     </div>
                     <div class="tp-app__download">
                        <h4 class="tp-app__title-sm ">{{ $home->about->action_area_title ?? '' }}</h4>
                        <div class="tp-app__thumb-sm d-flex">
                           @isset(get_option('header_footer',true,true)->footer_button_image)
                           <div class="tp-app__thumb-sm-1">
                             <a href="{{ get_option('header_footer',true,true)->footer->right_image_link ?? '' }}"><img src="{{ asset(get_option('header_footer',true,true)->footer_button_image ?? '' ) }}" alt=""></a>
                           </div>
                           @endisset

                           @isset(get_option('header_footer',true,true)->footer_left_button_image)
                           <div class="tp-app__thumb-sm-2">
                            <a href="{{ get_option('header_footer',true,true)->footer->right_image_link ?? '' }}"><img src="{{ asset(get_option('header_footer',true,true)->footer_left_button_image ?? '' ) }}" alt=""></a>
                         </div>
                         @endisset
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>