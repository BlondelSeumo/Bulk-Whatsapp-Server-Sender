@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['buttons'=>[
	[
		'name'=>'<i class="fa fa-backward"></i>&nbsp'. __('Back To Templates'),
		'url'=>url('/user/template'),
		'is_button'=>false
	],	
	[
		'name'=>'<i class="fa fa-backward"></i>&nbsp'. __('Back To Contacts'),
		'url'=>url('/user/contact'),
		'is_button'=>false
	]
]])
@endsection
@section('content')
<div class="row justify-content-center">
   <div class="col-12">
      <div class="row d-flex justify-content-between flex-wrap">
         <div class="col-sm-4">
            <div class="card card-stats">
               <div class="card-body">
                  <div class="row">
                     <div class="col">
                        <span class="h2 font-weight-bold mb-0 total-transfers total_sent">
                        0
                        </span>
                     </div>
                     <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                           <i class="fi fi-rs-rocket-lunch mt-2"></i>
                        </div>
                     </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                  </p>
                  <h5 class="card-title  text-muted mb-0">{{ __('Total Sent') }}</h5>
                  <p></p>
               </div>
            </div>
         </div>
         <div class="col-sm-4">
            <div class="card card-stats">
               <div class="card-body">
                  <div class="row">
                     <div class="col">
                        <span class="h2 font-weight-bold mb-0 total_records" id="total_records">{{ number_format(count($contacts)) }}</span>
                     </div>
                     <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                           <i class="fi  fi-rs-address-book mt-2"></i>
                        </div>
                     </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                  </p>
                  <h5 class="card-title  text-muted mb-0">{{ __('Total Contacts') }}</h5>
                  <p></p>
               </div>
            </div>
         </div>
         <div class="col-sm-4">
            <div class="card card-stats">
               <div class="card-body">
                  <div class="row">
                     <div class="col">
                        <span class="h2 font-weight-bold mb-0 completed-transfers total-faild">
                        0
                        </span>
                     </div>
                     <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                           <i class="fi fi-rs-circle-cross mt-2"></i>
                        </div>
                     </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                  </p>
                  <h5 class="card-title  text-muted mb-0">{{ __('Total Faild') }}</h5>
                  <p></p>
               </div>
            </div>
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <div class="row mb-3">
               <div class="col-12">
                  <div class="float-left">
                     <h4><span class="total_sent">0</span>/<span class="total_records">{{ count($contacts) }}</span></h4>
                  </div>
                  <div class="float-right">
                     <button class="btn  btn-neutral btn-sm  send_now" type="button"><i class="ni ni-send"></i>&nbsp&nbsp{{ __('Send To All') }}</button>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-12 table-responsive">
                  <table class="table col-12">
                     <thead>
                        <tr>
                           <th class="col-3">{{ __('Receiver (To)') }}</th>
                           <th class="col-3">{{ __('Device (From)') }}</th>
                           <th class="col-3">{{ __('Template') }}</th>
                           <th class="col-2">{{ __('Status') }}</th>
                           <th class="col-1">{{ __('Actions') }}</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($contacts as $key => $contact)
                        <tr class="contact_form_row{{ $key }}">
                           <form action="{{ url('user/sent-message-with-template') }}" method="POST" class="bulk_form form-{{  $key }}" data-key="{{ $key }}">
                              @csrf
                              <input type="hidden" name="contact" value="{{ $contact->id }}">
                              <td>{{ $contact->name.' - '.$contact->phone }}</td>
                              <td>
                                 <select class="form-control" name="device">
                                 @foreach($devices as $row)
                                 <option value="{{ $row->id }}" {{ $row->id ==  $device->id ? 'selected' : ''}}>{{ $row->name. ' - '. $row->phone }}</option>
                                 @endforeach
                                 </select>
                              </td>
                              <td>
                                 <select class="form-control" name="template">
                                 @foreach($templates as $template_row)
                                 <option value="{{ $template_row->id }}" {{ $template_row->id ==  $template->id ? 'selected' : ''}}>{{ $template_row->title }}</option>
                                 @endforeach
                                 </select>
                              </td>
                              <td>
                                 <span class="badge badge-warning badge_{{ $key }} sendable">{{ __('Waiting') }}</span>
                              </td>
                              <td>
                                 <div class="btn-group mb-2 float-right">
                                    <button class="btn btn-neutral btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('Action') }}
                                    </button>
                                    <div class="dropdown-menu">
                                       <a class="dropdown-item has-icon send-message submit-button" data-form=".form-{{  $key }}" href="javascript:void(0)"><i class="ni ni-send"></i>{{ __('Send Now') }}</a>
                                       <a class="dropdown-item has-icon delete-form" href="javascript:void(0)" data-action=".contact_form_row{{ $key }}"><i class="fas fa-trash"></i>{{ __('Remove') }}</a>
                                    </div>
                                 </div>
                              </td>
                           </form>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/js/pages/user/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/pages/user/template-bulk.js') }}"></script>
@endpush