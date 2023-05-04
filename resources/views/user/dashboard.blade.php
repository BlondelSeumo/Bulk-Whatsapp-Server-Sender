@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['title'=> __('Dashboard'),'buttons'=>[
  [
    'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create Device'),
    'url'=> route('user.device.create'),
  ],
  [
    'name'=>'<i class="fi fi-rs-paper-plane"></i>&nbsp'.__('Sent a message'),
    'url'=> url('/user/sent-text-message'),
  ],
]])
@endsection
@section('content')
<div class="row">
  <div class="col-xl-3 col-md-6">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Total Devices') }}</h5>
            <span class="h2 font-weight-bold mb-0" id="total-device"><img src="{{ asset('uploads/loader.gif') }}"></span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
             <i class="fas fa-server"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Total Messages') }}</h5>
            <span class="h2 font-weight-bold mb-0 mt-1" id="total-messages"><img src="{{ asset('uploads/loader.gif') }}"></span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
              <i class="ni ni-spaceship"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Pending Schedules') }}</h5>
            <span class="h2 font-weight-bold mb-0" id="total-schedule"><img src="{{ asset('uploads/loader.gif') }}"></span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
              <i class="ni ni-calendar-grid-58"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
   <div class="col-xl-3 col-md-6">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Total Contacts') }}</h5>
            <span class="h2 font-weight-bold mb-0" id="total-contacts"><img src="{{ asset('uploads/loader.gif') }}"></span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
              <i class="ni ni-collection"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="row">
 @if(Session::has('success'))
 <div class="col-sm-12">
   <div class="alert bg-gradient-success text-white alert-dismissible fade show success-alert" role="alert">
     <span class="alert-icon"><img src="{{ asset('uploads/firework.png') }}" alt=""></span>
     <span class="alert-text"><strong>{{ __('Congratulations ') }}</strong> {{ Session::get('success') }}</span>
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>
</div>
@endif
 @if(Session::has('saas_error'))
 <div class="col-sm-12">
   <div class="alert bg-gradient-primary text-white alert-dismissible fade show" role="alert">
     <a href="{{ url(Auth::user()->plan_id == null ? '/user/subscription' : '/user/subscription/'.Auth::user()->plan_id) }}">
      <span class="alert-icon"><i class="fi  fi-rs-info text-white"></i></span>
    </a>
    <span class="alert-text">
      <strong>{{ __('!Opps ') }}</strong> 
      <a class="text-white" href="{{ url(Auth::user()->plan_id == null ? '/user/subscription' : '/user/subscription/'.Auth::user()->plan_id) }}">
        {{ Session::get('saas_error') }}
      </a>
    </span>
  </div>
</div>
@endif
  <div class="col-sm-6">
    <div class="card">
       <div class="card-header bg-transparent">
        <h4 class="card-header-title">{{ __('Messages Transaction') }}</h4>
        <div class="card-header-action">
          <select class="form-control" id="period" >
            <option value="7">{{ __('Last 7 Days') }}</option>
            <option value="1">{{ __('Today') }}</option>
            <option value="30">{{ __('Last 30 Days') }}</option>
          </select>
        </div>
      </div>
      <div class="card-body">
        <!-- Chart -->
        <div class="chart">
          <!-- Chart wrapper -->
          <canvas id="chart-sales" class="chart-canvas"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <!--* Card header *-->
    <!--* Card body *-->
    <!--* Card init *-->
    <div class="card">
      <!-- Card header -->
      <div class="card-header">
        <!-- Surtitle -->
        <h4 class="h3 mb-0 card-header-title">{{ __('Automatic Replies') }}</h4>
        <div class="card-header-action">
          <select class="form-control" id="automaticReply" >
            <option value="7">{{ __('Last 7 Days') }}</option>
            <option value="1">{{ __('Today') }}</option>
            <option value="30">{{ __('Last 30 Days') }}</option>
          </select>
        </div>
      </div>
      <!-- Card body -->
      <div class="card-body">
        <div class="chart">
          <!-- Chart wrapper -->
          <canvas id="chart-bars" class="chart-canvas"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <!--* Card header *-->
    <!--* Card body *-->
    <!--* Card init *-->
    <div class="card">
      <!-- Card header -->
      <div class="card-header">
        <h4 class="h3 mb-0 card-header-title">{{ __('Messages') }}</h4>
        <div class="card-header-action">
          <select class="form-control" id="messagesTypes" >
            <option value="7">{{ __('Last 7 Days') }}</option>
            <option value="1">{{ __('Today') }}</option>
            <option value="30">{{ __('Last 30 Days') }}</option>
          </select>
        </div>
      </div>
      <!-- Card body -->
      <div class="card-body">
        <div class="chart">
          <!-- Chart wrapper -->
          <canvas id="chart-doughnut" class="chart-canvas"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card">
      <!-- Card header -->
      <div class="card-header bg-transparent">
        <!-- Title -->
        <h4 class="card-header-title">{{ __('Devices Statistics') }}</h4>
      </div>
      <!-- Card body -->
      <div class="card-body">
        <!-- List group -->
        <ul class="list-group list-group-flush list my--3" id="device-list">
          
        </ul>
      </div>
    </div>
  </div>
 </div>
<input type="hidden" id="static-data" value="{{ route('user.dashboard.static') }}"> 
<input type="hidden" id="base_url" value="{{ url('/') }}"> 

@endsection
@push('js')
<script src="{{ asset('assets/vendor/chart.js/dist/chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/canvas-confetti/confetti.browser.min.js') }}"></script>
@endpush
@push('bottomjs')
<script src="{{ asset('assets/js/pages/user/dashboard.js') }}"></script>
@endpush
