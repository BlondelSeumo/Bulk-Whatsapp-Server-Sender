@extends('layouts.main.app')
@push('topcss')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
@endpush
@section('head')
@include('layouts.main.headersection',['buttons'=>[
	[
		'name'=>'<i class="ni ni-send"></i>&nbsp'. __('Send Bulk Message'),
		'url'=>route('user.bulk-message.create'),
		'is_button'=>false
	],
	[
		'name'=>'<i class="ni ni-send"></i>&nbsp'. __('Send Bulk Message With Template'),
		'url'=>'#',
		'components'=>'data-toggle="modal" data-target="#send-template-bulk" id="send-template-bulks"',
		'is_button'=>true
	]
],'title' => 'Transaction History'])
@endsection
@section('content')
<div class="modal fade" id="send-template-bulk" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
   <div class="modal-dialog">
      @if(count($templates) > 0 && count($contacts) > 0)
      <div class="modal-content">
         <form type="POST" action="{{ route('user.contact.send-template-bulk') }}" class="ajaxform bulk_send_form">
            @csrf
            <input type="hidden" name="page_url" value="{{ url()->full() }}">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">{{ __('Send Bulk Message With Template') }}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Select Template') }}</label>
                  <select  class="form-control" name="template">
                     @foreach($templates as $template)
                     <option value="{{ $template->id }}">{{ $template->title }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label>{{ __('Select Device') }}</label>
                  <select  class="form-control" name="device">
                     @foreach($devices as $device)
                     <option value="{{ $device->id }}">{{ $device->name }} - {{ $device->phone }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group receivers">
                  <label>{{ __('Select Receivers') }}</label>
                  <select  class="form-control select2" name="contacts[]" multiple="">
                     @foreach($contacts as $conatct)
                     <option value="{{ $conatct->id }}">({{ $conatct->name }}) - {{ $conatct->phone }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group d-flex">
                  <label class="custom-toggle custom-toggle-primary">
                  <input type="checkbox"  name="sentall" id="plain-text"  data-target=".plain-title" class="save-template">
                  <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                  </label>
                  <label class="mt-1 ml-1" for="plain-text">
                     <h4>{{ __('Sent this template to all user?') }}</h4>
                  </label>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-neutral submit-btn float-right">{{ __('Sent Now') }}</button>
            </div>
         </form>
      </div>
      @else
      <div class="alert  bg-gradient-primary text-white"><span class="text-left">{{ __('Create some template and contacts') }}</span></div>
      @endif
   </div>
</div>
<div class="row justify-content-center">
   <div class="col-12">
      <div class="row d-flex justify-content-between flex-wrap">
         <div class="col">
            <div class="card card-stats">
               <div class="card-body">
                  <div class="row">
                     <div class="col">
                        <span class="h2 font-weight-bold mb-0 total-transfers">{{ number_format($total) }}</span>
                     </div>
                     <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                           <i class="fi fi-rs-rocket-lunch mt-2"></i>
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
         <div class="col">
            <div class="card card-stats">
               <div class="card-body">
                  <div class="row">
                     <div class="col">
                        <span class="h2 font-weight-bold mb-0 completed-transfers">{{ number_format($today_transaction) }}</span>
                     </div>
                     <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                           <i class="fi fi-rs-calendar-day mt-2"></i>
                        </div>
                     </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                  </p>
                  <h5 class="card-title  text-muted mb-0">{{ __('Today\'s Transaction') }}</h5>
                  <p></p>
               </div>
            </div>
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <div class="row">
               @if(count($posts) > 0)
               <div class="col-sm-12">
                  <h4>{{ __('Transaction History') }}</h4>
               </div>
               <div class="col-sm-12 table-responsive">
                  <table class="table col-12">
                     <thead>
                        <tr>
                        	<th>{{ __('Message From') }}</th>
                        	<th>{{ __('Message To') }}</th>
                        	<th>{{ __('Message Type') }}</th>
                        	<th>{{ __('Template name') }}</th>
                        	<th class="text-right">{{ __('Requested At') }}</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($posts as $log)
                        <tr>
                        	<td>
                        		{{ $log->from }}
                        	</td>
                        	<td>
                        		{{ $log->to }}
                        	</td>
                        	<td>{{ $log->template != null ? 'Template' : 'Plain Text' }}</td>

                        	<td>
                        		{{ $log->template->title ?? '' }}
                        	</td>
                        	<td class="text-right">
                        		{{ $log->created_at->format('d F Y') }}
                        	</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  <div class="d-flex justify-content-center">{{ $posts->links('vendor.pagination.bootstrap-4') }}</div>
               </div>
               @else
               <div class="btn btn-neutral  col-12 text-center">{{ __('No Transaction Found') }}</div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('topjs')
<script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/user/wa-bulk-index.js') }}" ></script>
@endpush