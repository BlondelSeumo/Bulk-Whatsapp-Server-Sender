 <header>
   <!-- tp-header-area-start -->
   <div class="tp-header__top-area theme-bg tp-header__space-3 d-none d-sm-block">
      <div class="container-fluid">
         <div class="row align-items-center">
            <div class="col-xxl-8 col-xl-8 col-lg-6 col-md-6 col-6">
               <div class="tp-header__top-left">
                  <a href="tel:{{ get_option('primary_data',true)->contact_phone ?? '' }}">
                     <svg width="14" height="19" viewBox="0 0 14 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="2" cy="2" r="2" fill="#3EB7FD" />
                        <circle cx="7" cy="2" r="2" fill="#3EB7FD" />
                        <circle cx="12" cy="2" r="2" fill="#3EB7FD" />
                        <circle cx="12" cy="7" r="2" fill="#3EB7FD" />
                        <circle cx="12" cy="12" r="2" fill="#3EB7FD" />
                        <circle cx="7" cy="7" r="2" fill="#3EB7FD" />
                        <circle cx="7" cy="12" r="2" fill="#3EB7FD" />
                        <circle cx="7" cy="17" r="2" fill="#3EB7FD" />
                        <circle cx="2" cy="7" r="2" fill="#3EB7FD" />
                        <circle cx="2" cy="12" r="2" fill="#3EB7FD" />
                     </svg>
                     <span>{{ __('Help Desk') }} : <b class="frist-child">+{{ get_option('primary_data',true)->contact_phone ?? '' }}</b></span>
                  </a>
                  @isset(get_option('header_footer',true,true)->header)
                   @if(!empty(get_option('header_footer',true,true)->header->announcement_title ?? ''))
                     <a class="last-child" href="{{ get_option('header_footer',true,true)->header->announcement_link ?? '' }}">
                        <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path
                           d="M16 7.3125C16 6.68359 15.6445 6.10938 15.125 5.80859V1.65234C15.125 1.40625 14.9336 0.75 14.25 0.75C14.0312 0.75 13.8398 0.832031 13.7031 0.96875L11.3516 2.82812C10.2031 3.75781 8.72656 4.25 7.25 4.25H2C1.01562 4.25 0.25 5.04297 0.25 6V8.625C0.25 9.60938 1.01562 10.375 2 10.375H2.90234C2.875 10.6758 2.84766 10.9766 2.84766 11.25C2.84766 12.3438 3.09375 13.3828 3.55859 14.2852C3.69531 14.5859 3.99609 14.75 4.32422 14.75H6.34766C7.05859 14.75 7.49609 13.957 7.05859 13.3828C6.62109 12.7812 6.34766 12.0703 6.34766 11.25C6.34766 10.9492 6.40234 10.6758 6.45703 10.375H7.25C8.72656 10.375 10.2031 10.8945 11.3516 11.8242L13.7031 13.6836C13.8125 13.793 14.0586 13.875 14.2227 13.875C14.9062 13.875 15.0977 13.2734 15.0977 13V8.84375C15.6445 8.54297 16 7.96875 16 7.3125ZM13.375 11.1953L12.4453 10.457C10.9688 9.28125 9.13672 8.625 7.25 8.625V6C9.13672 6 10.9688 5.37109 12.4453 4.19531L13.375 3.45703V11.1953Z"
                           fill="#3EB7FD" />
                        </svg>
                        <span><b>{{ get_option('header_footer',true,true)->header->announcement_type ?? '' }}: </b>{{ get_option('header_footer',true,true)->header->announcement_title ?? '' }}</span>
                     </a>
                   @endif
                  @endif
               </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-6">
               <div class="tp-header__top-right text-end">
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
   </div>

   <div id="header-sticky"
   class="tp-header__area tp-header__space-3 tp-header__transparent z-index-5 tp-header__bottom p-relative">
   <div class="container-fluid">
      <div class="row align-items-center">
         <div class="col-xl-2 col-lg-2 col-md-6 col-7">
            <div class="tp-header__logo">
               <a href="{{ url('/') }}">
                  <img src="{{ asset(get_option('primary_data',true)->logo ?? '') }}" alt="">
               </a>
            </div>
         </div>
         <div class="col-xl-7 col-lg-7 d-none d-lg-block">
            <div class="tp-header__main-menu tp-header__black-menu tp-header__menu-3">
               <nav id="mobile-menu">
                  <ul>
                    {{ PrintMenu('main-menu') }}
                 </ul>
              </nav>
           </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-5">
         <div class="tp-header__right-two d-flex align-items-center justify-content-end">
            <a class="tp-btn-blue-square d-none d-md-block" href="{{ !Auth::check() ? url('/pricing') : url('/login') }}"><span>{{ !Auth::check() ? __('Get Started') : __('Dashboard') }}</span></a>
            <a class="tp-header__bars tp-menu-bar d-lg-none" href="#"><i class="far fa-bars"></i></a>
         </div>
      </div>
   </div>
</div>
</div>

<!-- tp-header-area-end -->
</header>

<!-- tp-offcanvus-area-start -->
<div class="tp-offcanvas-area">
   <div class="tpoffcanvas">
      <div class="tpoffcanvas__close-btn">
         <button class="close-btn"><i class="fal fa-times"></i></button>
      </div>
      <div class="tpoffcanvas__logo">
         <a href="{{ url('/') }}">
            <img src="{{ asset(get_option('primary_data',true)->logo ?? '') }}" alt="">
         </a>
      </div>
      <div class="tpoffcanvas__text"></div>
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
               <a href="tel:+{{ get_option('primary_data',true)->contact_phone ?? '' }}">{{ get_option('primary_data',true)->contact_phone ?? '' }}</a>
            </div>
         </div>
         <div class="tp-info-wrapper mb-20 d-flex align-items-center">
            <div class="tpoffcanvas__info-icon">
               <a href="#"><i class="fas fa-map-marker-alt"></i></a>
            </div>
            <div class="tpoffcanvas__info-address">
               <span>{{ __('Location') }}</span>
               <a href="#">{{ get_option('primary_data',true)->address ?? '' }}</a>
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
<div class="body-overlay"></div>
   <!-- tp-offcanvus-area-end -->