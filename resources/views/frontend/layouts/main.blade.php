<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
   {!! SEOMeta::generate() !!}
   {!! OpenGraph::generate() !!}
   {!! Twitter::generate() !!}
   {!! JsonLd::generate() !!}
   
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Place favicon.ico in the root directory -->
   <link rel="shortcut icon" type="image/x-icon" href="{{ asset(get_option('primary_data',true)->favicon ?? '') }}">

   <!-- CSS here -->
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/animate.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/custom-animation.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/swiper-bundle.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/slick.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/nice-select.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/flaticon.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/meanmenu.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/font-awesome-pro.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/magnific-popup.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/spacing.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
</head>

<body>
   <!-- back-to-top-start  -->
   <button class="scroll-top scroll-to-target" data-target="html">
      <i class="far fa-angle-double-up"></i>
   </button>
   <!-- back-to-top-end  -->
    @yield('content')
    <div class="body-overlay"></div>

    @include('frontend.layouts.footer')

   <!-- JS here -->
   <script src="{{ asset('assets/frontend/js/jquery.js') }}"></script>
   <script src="{{ asset('assets/frontend/js/waypoints.js') }}"></script>
   <script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('assets/frontend/js/swiper-bundle.js') }}"></script>
   <script src="{{ asset('assets/frontend/js/slick.js') }}"></script>
   <script src="{{ asset('assets/frontend/js/magnific-popup.js') }}"></script>
   <script src="{{ asset('assets/frontend/js/counterup.js') }}"></script>
   <script src="{{ asset('assets/frontend/js/wow.js') }}"></script>
   <script src="{{ asset('assets/frontend/js/nice-select.js') }}"></script>
   <script src="{{ asset('assets/frontend/js/meanmenu.js') }}"></script>
   <script src="{{ asset('assets/frontend/js/isotope-pkgd.js') }}"></script>
   <script src="{{ asset('assets/frontend/js/imagesloaded-pkgd.js') }}"></script>
   <script src="{{ asset('assets/frontend/js/ajax-form.js') }}"></script>
   <script src="{{ asset('assets/frontend/js/main.js') }}"></script>



</body>
</html>