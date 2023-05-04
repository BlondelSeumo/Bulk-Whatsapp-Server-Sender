@extends('installer.app')
@section('content')
@php
$enabled=true;
@endphp
<div class="col-sm-12">
   <h3 class="text-center mt-2">{{ __('Enter Site name and database connection credentials') }}</h3>
   <form class="installer_form_instant_reload" method="post" action="{{ route('install.store') }}">
      @csrf
      <div class="form-group mt-5">
         <label>{{ __('Enter your site name') }}</label>
         <input type="text" name="site_name" class="form-control" required="" placeholder="WASender" maxlength="20">
      </div>
      <div class="form-group mb-2">
         <label>{{ __('Database Connection Driver') }}</label>
         <input type="text" name="db_connection" class="form-control" required="" placeholder="mysql" maxlength="20" value="mysql">
      </div>
      <div class="form-row">
         <div class="col-sm-6">
            <div class="form-group">
               <label>{{ __('Database Host') }}</label>
               <input type="text" name="db_host" class="form-control" required="" placeholder="localhost" maxlength="20" value="localhost">
            </div>
         </div>
         <div class="col-sm-6">
            <div class="form-group">
               <label>{{ __('Database Port') }}</label>
               <input type="number" name="db_port" class="form-control" required="" placeholder="3306" maxlength="20" value="3306">
            </div>
         </div>
      </div>
      <div class="form-group">
         <label>{{ __('Database Name') }}</label>
         <input type="text" name="db_name" class="form-control" required="" placeholder="Enter Your Database Name">
      </div>
      <div class="form-group">
         <label>{{ __('Database Username') }}</label>
         <input type="text" name="db_user" class="form-control" required="" placeholder="Enter Your Database Username">
      </div>
      <div class="form-group">
         <label>{{ __('Database Password') }}</label>
         <input type="text" name="db_pass" class="form-control"  placeholder="Enter Your Database Password">
         <small>{{ __('Note:') }} <span class="text-danger">{{ __('do not use hash(#)') }}</span></small>
      </div>
      <div class="alert alert-primary alert-dismissible fade hide none waiting-bar" role="alert">
         <span class="alert-icon">📣</span>
         <span class="alert-text"><strong>{{ __('Note: ') }}</strong> {{ __('It will take a while of moments. Do not close this tab.') }}</span>
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">×</span>
         </button>
      </div>
      <button class="btn btn-outline-primary mt-1 submit-btn">
      <span class="mb-1">{{ __('Submit & Next') }}</span> 
      <i class="fi  fi-rs-angle-right text-right mt-5"></i>
      </button>
      <a href="https://youtu.be/TAbs7tba5kE" target="_blank" class="float-right">
         <h4 class="text-primary">{{ __('How to create database?') }}</h4>
      </a>
   </form>
</div>
<div class="clear"></div>
<br>
<form method="post" action="{{ route('install.migrate') }}" id="install-migrate">@csrf</form>
@endsection
@push('js')
<script src="{{ asset('assets/js/installer.js?v=1') }}"></script>
@endpush
