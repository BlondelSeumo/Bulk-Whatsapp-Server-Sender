@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=>__('Device'),
'buttons'=>[
[
'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create Device'),
'url'=> route('user.device.create'),
]
]])
@endsection
@section('content')
<div class="row justify-content-center">
   <div class="col-12">
      <div class="row d-flex justify-content-between flex-wrap">
         <div class="col">
            <div class="card card-stats">
               <div class="card-body">
                  <div class="row">
                     <div class="col">
                        <span class="h2 font-weight-bold mb-0 total-transfers" id="total-device">
                        <img src="{{ asset('uploads/loader.gif') }}">
                        </span>
                     </div>
                     <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                           <i class="fi fi-rs-devices mt-2"></i>
                        </div>
                     </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                  </p>
                  <h5 class="card-title  text-muted mb-0">{{ __('Total Devices') }}</h5>
                  <p></p>
               </div>
            </div>
         </div>
         <div class="col">
            <div class="card card-stats">
               <div class="card-body">
                  <div class="row">
                     <div class="col">
                        <span class="h2 font-weight-bold mb-0 total-transfers" id="total-active">
                        <img src="{{ asset('uploads/loader.gif') }}">
                        </span>
                     </div>
                     <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                           <i class="fi fi-rs-badge-check mt-2"></i>
                        </div>
                     </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                  </p>
                  <h5 class="card-title  text-muted mb-0">{{ __('Active Devices') }}</h5>
                  <p></p>
               </div>
            </div>
         </div>
         <div class="col">
            <div class="card card-stats">
               <div class="card-body">
                  <div class="row">
                     <div class="col">
                        <span class="h2 font-weight-bold mb-0 completed-transfers" id="total-inactive">
                        <img src="{{ asset('uploads/loader.gif') }}">
                        </span>
                     </div>
                     <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                           <i class="fi  fi-rs-exclamation mt-2"></i>
                        </div>
                     </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                  </p>
                  <h5 class="card-title  text-muted mb-0">{{ __('Inactive Devices') }}</h5>
                  <p></p>
               </div>
            </div>
         </div>
      </div>
      @if(count($devices ?? []) > 0)
      <div class="row">
      @foreach($devices ?? [] as $device)
      <div class="col-xl-4 col-md-6">
         <div class="card  border-0">
            <!-- Card body -->
            <div class="card-body">
               <div class="row">
                  <div class="col">
                     <h5 class="card-title text-uppercase text-muted mb-0 text-dark">{{ $device->name }}</h5>
                     <div class="mt-3 mb-0">
                        <span class="pt-2 text-dark">{{__('Phone :')}} 
                        @if(!empty($device->phone))
                        <a href="{{ route('user.device.scan',$device->uuid) }}">
                        {{ $device->phone  }}
                        </a>
                        @endif
                        </span>	  
                        <br>
                        <br>
                        <span class="pt-2 text-dark">{{__('Total Messages:')}} {{ number_format($device->smstransaction_count) }}
                     </div>
                  </div>
                  <div class="col-auto">
                     <button type="button" class="btn btn-sm btn-neutral mr-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="fas fa-ellipsis-h"></i>
                     </button>
                     <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item has-icon" href="{{ route('user.device.scan',$device->uuid) }}"><i class="fas fa-qrcode"></i>{{ __('Scan') }}</a>
                        @if($device->status == 1)
                        <a class="dropdown-item has-icon" href="{{ url('/user/device/chats/'.$device->uuid) }}"><i class="fi fi-rs-comments-question-check"></i>{{ __('Chats') }}</a>
                        <a class="dropdown-item has-icon" href="{{ url('/user/device/groups/'.$device->uuid) }}"><i class="fi fi-rs-folder-tree"></i>{{ __('Groups') }}</a>
                        @endif
                        <a class="dropdown-item has-icon" href="{{ route('user.device.edit',$device->uuid) }}"><i class="fi  fi-rs-edit"></i>{{ __('Edit Device Name') }}</a>
                        <a class="dropdown-item has-icon" href="{{ route('user.device.show',$device->uuid) }}"><i class="ni ni-align-left-2"></i>{{ __('View Log') }}</a>
                        <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-action="{{ route('user.device.destroy',$device->uuid) }}"><i class="fas fa-trash"></i>{{ __('Remove Device') }}</a>
                     </div>
                  </div>
               </div>
               <p class="mt-3 mb-0 text-sm">
                  <a class="text-nowrap  font-weight-600" href="{{ route('user.device.scan',$device->uuid) }}">
                  <span class="text-dark">{{ __('Status :') }}</span>
                  <span class="badge badge-sm {{ badge($device->status)['class'] }}">
                  {{ $device->status == 1 ? __('Active') : __('Inactive')  }}
                  </span>
                  </a>
               </p>
            </div>
         </div>
      </div>
      @endforeach
      </div>
      @else
      <div class="alert  bg-gradient-primary text-white"><span class="text-left">{{ __('Opps There Is No Device Found....') }}</span></div>
      @endif
   </div>
</div>

<input type="hidden" id="base_url" value="{{ url('/') }}">
@endsection
@push('js')
<script src="{{ asset('assets/js/pages/user/device.js') }}"></script>
@endpush