@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title' => __('Apps'),
'buttons'=>[
   [
      'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create App'),
      'url'=>'#',
      'components'=>'data-toggle="modal" data-target="#addRecord" id="add_record"',
      'is_button'=>true
   ]
]])
@endsection
@section('content')
<div class="row d-flex justify-content-between flex-wrap">
   <div class="col">
      <div class="card card-stats">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <span class="h2 font-weight-bold mb-0 total-transfers">{{ $limit }}</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                     <i class="fi fi-rs-apps-add mt-2"></i>
                  </div>
               </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
            </p>
            <h5 class="card-title  text-muted mb-0">{{ __('Total App') }}</h5>
            <p></p>
         </div>
      </div>
   </div>
   <div class="col">
      <div class="card card-stats">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <span class="h2 font-weight-bold mb-0 total-transfers">{{ number_format($total) }}</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                     <i class="fas fa-paper-plane"></i>
                  </div>
               </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
            </p>
            <h5 class="card-title  text-muted mb-0">{{ __('Total Messages Sent') }}</h5>
            <p></p>
         </div>
      </div>
   </div>
   <div class="col">
      <div class="card card-stats">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <span class="h2 font-weight-bold mb-0 pending-transfers">{{ number_format($last30_messages ?? 0) }}</span>
               </div>
               <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                     <i class="ni ni-calendar-grid-58"></i>
                  </div>
               </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
            </p>
            <h5 class="card-title  text-muted mb-0">{{ __('Last 30 days Messages') }}</h5>
            <p></p>
         </div>
      </div>
   </div>
</div>
<div class="row">
@if(count($apps ?? []) == 0)
<div class="col-sm-12">
   <div class="card">
      <div class="card-body">
         <center>
            <img src="{{ asset('assets/img/404.jpg') }}" height="500">
            <h1 class="text-center">{{ __('!Opps You Have Not Created Any APP') }}</h1>
         </center>
      </div>
   </div>
</div>
@endif
@foreach($apps as $app)
<div class="col-xl-4 col-md-6">
   <div class="card  border-0">
      <!-- Card body -->
      <div class="card-body">
         <div class="row">
            <div class="col">
               <h5 class="card-title text-uppercase text-muted mb-0 text-dark">{{ $app->title }}</h5>
               <div class="mt-3 mb-0">
                  <span class="pt-2 text-dark">{{__('Messages Count:')}} ({{number_format($app->live_messages_count)}})
                  <br>
                  <span class="pt-2 text-dark">{{__('Device:')}} {{$app->device->phone ?? ''}}
               </div>
            </div>
            <div class="col-auto">
               <button type="button" class="btn btn-sm btn-neutral mr-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-ellipsis-h"></i>
               </button>
               <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="{{ route('user.app.logs',$app->uuid) }}">{{ __('Messages Log') }}</a>
                  <a class="dropdown-item" href="{{ route('user.app.integration',$app->uuid) }}">{{ __('REST API') }}</a>
                  <a class="dropdown-item delete-confirm" href="javascript:void(0)" data-action="{{ route('user.apps.destroy',$app->uuid) }}">{{ __('Remove APP') }}</a>
               </div>
            </div>
         </div>
         <p class="mt-3 mb-0 text-sm">
            <a href="{{ route('user.app.integration',$app->uuid) }}" class="text-nowrap  font-weight-600">{{ __('Integration') }} <i class="fa fa-arrow-right"></i></a>
         </p>
      </div>
   </div>
</div>
@endforeach
<div class="col-sm-12">
   <div class="d-flex justify-content-center">{{ $apps->links('vendor.pagination.bootstrap-4') }}</div>
</div>
<div class="modal fade" id="addRecord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="{{ route('user.apps.store') }}" class="ajaxform_instant_reload">
            @csrf
            <div class="modal-header">
               <h3>{{ __('Create New App') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Select Number') }}</label>
                  <select class="form-control"  name="device" required="">
                     @foreach($devices as $device)
                     <option value="{{ $device->id }}">
                        {{ $device->name }} 
                        @if(!empty($device->phone)) 
                        ({{ $device->phone }}) 
                        @endif
                     </option>
                     @endforeach
                  </select>
                  <small>{{ __('User Will Receive Message From The Selected Number') }}</small>
               </div>
               <div class="form-group">
                  <label>{{ __('App Name') }}</label>
                  <input type="text" name="name" class="form-control" required>
               </div>
               <div class="form-group">
                  <label>{{ __('Website Link') }}</label>
                  <input type="url" name="website" class="form-control" required="">
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-outline-primary col-12" >{{ __('Create Now') }}</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection