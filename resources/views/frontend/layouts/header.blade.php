<header>
      <!-- tp-header-area-start -->
      <div id="header-sticky" class="tp-header__area tp-header__space-2 tp-header__transparent tp-header__menu-space">
         <div class="container-fluid">
            <div class="row align-items-center">
               <div class="col-xl-2 col-lg-2 col-md-6 col-6">
                  <div class="tp-header__logo">
                     <a href="{{ url('/') }}">
                        <img src="{{ asset(get_option('primary_data',true)->logo ?? '') }}" alt="">
                     </a>
                  </div>
               </div>
               <div class="col-xl-7 col-lg-7 d-none d-lg-block">
                  <div class="tp-header__main-menu tp-header__black-menu">
                     <nav id="mobile-menu">
                        <ul>
                           {{ PrintMenu('main-menu') }}
                        </ul>
                     </nav>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                  <div class="tp-header__right-two d-flex align-items-center justify-content-end">
                     @if(!Auth::check())
                     <a class="tp-header__login d-none d-lg-block" href="{{ url('/login') }}">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path
                              d="M15.364 11.636C14.3837 10.6558 13.217 9.93013 11.9439 9.49085C13.3074 8.55179 14.2031 6.9802 14.2031 5.20312C14.2031 2.33413 11.869 0 9 0C6.131 0 3.79688 2.33413 3.79688 5.20312C3.79688 6.9802 4.69262 8.55179 6.05609 9.49085C4.78308 9.93013 3.61631 10.6558 2.63605 11.636C0.936176 13.3359 0 15.596 0 18H1.40625C1.40625 13.8128 4.81279 10.4062 9 10.4062C13.1872 10.4062 16.5938 13.8128 16.5938 18H18C18 15.596 17.0638 13.3359 15.364 11.636ZM9 9C6.90641 9 5.20312 7.29675 5.20312 5.20312C5.20312 3.1095 6.90641 1.40625 9 1.40625C11.0936 1.40625 12.7969 3.1095 12.7969 5.20312C12.7969 7.29675 11.0936 9 9 9Z"
                              fill="currentColor" />
                        </svg>
                        <span>{{ __('Login') }}</span>
                     </a>
                     @endif
                     <a class="tp-btn-blue d-none d-md-block" href="{{ !Auth::check() ? url('/pricing') : url('/login') }}"><span>{{ !Auth::check() ? __('Get Started') : __('Dashboard') }}</span></a>
                     <a class="tp-header__bars tp-menu-bar d-lg-none" href="#"><i class="far fa-bars"></i></a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- tp-header-area-end -->
   </header>


   <div class="tp-offcanvas-area">
      <div class="tpoffcanvas">
         <div class="tpoffcanvas__close-btn">
            <button class="close-btn"><i class="fal fa-times"></i></button>
         </div>
         <div class="tpoffcanvas__logo">
            <a href="{{ url('/') }}">
               <img src="{{ asset(get_option('primary_data',true)->footer_logo ?? '') }}" alt="">
            </a>
         </div>
        
         <div class="mobile-menu"></div>
         <div class="tpoffcanvas__info">
            <h3 class="offcanva-title">{{ __('Get In Touch') }}</h3>
            <div class="tp-info-wrapper mb-20 d-flex align-items-center">
               <div class="tpoffcanvas__info-icon">
                  <a href="#"><i class="fal fa-envelope"></i></a>
               </div>
               <div class="tpoffcanvas__info-address">
                  <span>{{ __('Email') }}</span>
                  <a href="maito:{{ get_option('primary_data',true)->contact_email ?? '' }}">{{ get_option('primary_data',true)->contact_email ?? '' }}</a>
               </div>
            </div>
            <div class="tp-info-wrapper mb-20 d-flex align-items-center">
               <div class="tpoffcanvas__info-icon">
                  <a href="#"><i class="fal fa-phone-alt"></i></a>
               </div>
               <div class="tpoffcanvas__info-address">
                  <span>{{ __('Phone') }}</span>
                  <a href="tel:{{ get_option('primary_data',true)->contact_phone ?? '' }}">{{ get_option('primary_data',true)->contact_phone ?? '' }}</a>
               </div>
            </div>
            <div class="tp-info-wrapper mb-20 d-flex align-items-center">
               <div class="tpoffcanvas__info-icon">
                  <a href="#"><i class="fas fa-map-marker-alt"></i></a>
               </div>
               <div class="tpoffcanvas__info-address">
                  <span>{{ __('Location') }}</span>
                  <a href="#" target="_blank">{{ get_option('primary_data',true)->address ?? '' }}</a>
               </div>
            </div>
         </div>
         <div class="tpoffcanvas__social">
            <div class="social-icon">
               @if(!empty(get_option('primary_data',true)->socials->twitter))
               <a href="{{ get_option('primary_data',true)->socials->twitter }}"><i class="fab fa-twitter"></i></a>
               @endif
               @if(!empty(get_option('primary_data',true)->socials->instagram))
               <a href="{{ get_option('primary_data',true)->socials->instagram }}"><i class="fab fa-instagram"></i></a>
               @endif
               @if(!empty(get_option('primary_data',true)->socials->facebook))
               <a href="{{ get_option('primary_data',true)->socials->facebook }}"><i class="fab fa-facebook-square"></i></a>
               @endif
               @if(!empty(get_option('primary_data',true)->socials->linkedin))
               <a href="{{ get_option('primary_data',true)->socials->linkedin }}"><i class="fab fa-linkedin"></i></a>
               @endif
            </div>
         </div>
      </div>
   </div>