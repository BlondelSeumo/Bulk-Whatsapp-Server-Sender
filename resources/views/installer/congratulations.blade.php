@extends('installer.app')
@section('content')
@php
$enabled=true;
@endphp
<div class="col-sm-12">
   <h1 class="text-center mt-5 success-alert">🎉 {{ __('Congratulations Installlation is complete') }}</h1>
   
   <div class="row">
      <div class="col-sm-6 text-right">
         <a href="{{ url('/') }}" class="btn btn-neutral"><i class="fi fi-rs-rocket-lunch"></i> {{ __('Go to the main site') }}</a>
      </div>
       <div class="col-sm-6 text-left">
         <a href="{{ url('/login') }}" class="btn btn-neutral"><i class="fi fi-rs-user"></i> {{ __('Login to admin') }}</a>
      </div>      
   </div>
</div>
<div class="clear"></div>
<br>      
@endsection
@push('js')
<script src="{{ asset('assets/plugins/canvas-confetti/confetti.browser.min.js') }}"></script>
<script src="{{ asset('assets/js/installer.js') }}"></script>
@endpush
