 <footer>
   <!-- tp-footer-area-start -->
   <div class="tp-footer__area theme-bg pt-120 pb-50">
      <div class="container">
         <div class="row">
            <div class="col-xl-12">
               <div class="tp-footer__content text-center">
                  <h3 class="tp-section-title text-white wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">{{ get_option('header_footer',true,true)->footer->title ?? ''  }}</h3>
                  <p class="wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">{{ get_option('header_footer',true,true)->footer->description ?? ''  }}</p>
               </div>
               <div class="tp-footer__thumb d-flex justify-content-center wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".7s">
                  @isset(get_option('header_footer',true,true)->footer_button_image)
                  <div class="tp-footer__thumb-sm">
                     <a href="{{ get_option('header_footer',true,true)->footer->right_image_link ?? '' }}"><img src="{{ asset(get_option('header_footer',true,true)->footer_button_image ?? '' ) }}" alt=""></a>
                  </div>
                  @endisset
                 
                  @isset(get_option('header_footer',true,true)->footer_left_button_image)
                  <div class="tp-footer__thumb-sm">
                     <a href="{{ get_option('header_footer',true,true)->footer->right_image_link ?? '' }}"><img src="{{ asset(get_option('header_footer',true,true)->footer_left_button_image ?? '' ) }}" alt=""></a>
                  </div>
                  @endisset
                  
               </div>
            </div>
         </div>
      </div>
      <div class="tp-footer-bottom__area mt-80 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".9s">
         <div class="container">
            <div class="tp-footer-bottom__border-top pt-40">
               <div class="row align-items-center">
                  <div class="col-xl-2 col-lg-2 col-md-6 col-12 order-2 order-lg-1 text-center text-md-start">
                     <div class="tp-footer-bottom__logo">
                        <a href="{{ url('/') }}"><img src="{{ asset(get_option('primary_data',true)->footer_logo ?? '') }}" alt=""></a>
                     </div>
                  </div>
                  <div class="col-xl-7 col-lg-7 col-md-12 col-12 order-1 order-lg-2 d-none d-sm-block">
                     <div class="tp-footer-bottom__menu">
                        <ul>
                           <li><a href="{{ url('/features') }}">{{ __('Features') }}</a></li>
                           <li><a href="{{ url('/about') }}">{{ __('About Us') }}</a></li>
                           <li><a href="{{ url('/pricing') }}">Pricing</a></li>
                           <li><a href="{{ url('/faq') }}">{{ __('FAQ') }}</a></li>
                           <li><a href="{{ url('/blogs') }}">{{ __('News') }}</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-12 order-2 order-lg-3 text-center text-md-end">
                     <div class="tp-footer-bottom__social">
                        <ul>
                           @if(!empty(get_option('primary_data',true)->socials->facebook))
                           <li><a href="{{ get_option('primary_data',true)->socials->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                           @endif
                           @if(!empty(get_option('primary_data',true)->socials->youtube))
                           <li><a href="{{ get_option('primary_data',true)->socials->youtube }}"><i class="fab fa-youtube"></i></a></li>
                           @endif
                           @if(!empty(get_option('primary_data',true)->socials->instagram))
                           <li><a href="{{ get_option('primary_data',true)->socials->instagram }}"><i class="fab fa-instagram"></i></a></li>
                           @endif
                           @if(!empty(get_option('primary_data',true)->socials->twitter))
                           <li><a href="{{ get_option('primary_data',true)->socials->twitter }}"><i class="fab fa-twitter"></i></a></li>
                           @endif
                           @if(!empty(get_option('primary_data',true)->socials->linkedin))
                           <li><a href="{{ get_option('primary_data',true)->socials->linkedin }}"><i class="fab fa-linkedin"></i></a></li>
                           @endif
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- tp-footer-area-end -->
</footer>