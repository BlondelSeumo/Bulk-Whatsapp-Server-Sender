@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title' => __('Chat List'),
'buttons'=>[
[
'name'=> __('Devices List'),
'url'=> route('user.device.index'),
]
]])
@endsection
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/qr-page.css') }}">
@endpush
@section('content')

<div class="card">
	<div class="card-body position-relative">
		<div class="row">
			@if(getUserPlanData('access_chat_list') == true)
			<div class="col-sm-4" >
				<div class="form-group">
					<input type="text" data-target=".contact" class="form-control filter-row" placeholder="{{ __('Search....') }}">
				</div>
				<div class="d-flex justify-content-center qr-area">
					<div class="justify-content-center">
						&nbsp&nbsp
						<div class="spinner-grow text-primary" role="status">
							<span class="sr-only">{{ __('Loading...') }}</span> 
						</div>
						<br>
						<p><strong>{{ __('Loading Contacts.....') }}</strong></p>
					</div>

				</div>
				<div class="alert bg-gradient-red server_disconnect none text-white" role="alert">
					{{ __('Opps! Server Disconnected 😭') }}
				</div>
				<ul class="list-group list-group-flush list my--3 contact-list mt-5 position-relative">
				</ul>
			</div>
			<div class="col-sm-8 mt-5" >
					<div class="text-center">
						<img src="{{ asset('assets/img/whatsapp-bg.png') }}" class="wa-bg-img">
					</div>
					<form method="post" class="ajaxform" action="{{ route('user.chat.send-message',$device->uuid) }}">
						@csrf
						<div class="form-group mb-5  none sendble-row">
							<label>{{ __('Reciver') }}</label>
							<input type="number" readonly="" name="reciver" value="" class="form-control bg-white reciver-number">
						</div>
						<div class="input-group none sendble-row wa-content-area" >
							<select class="form-control" name="selecttype" id="select-type">
								<option value="plain-text">{{ __('Plan Text') }}</option>
								@if(count($templates) > 0)
								<option value="template">{{ __('Template') }}</option>
								@endif
							</select>
							@if(count($templates) > 0)
							<select class="form-control none" name="template" id="templates">
								@foreach($templates as $template)
								<option value="{{ $template->id }}">{{ $template->title }}</option>
								@endforeach
							</select>
							@endif
							<input type="text" name="message" class="form-control" id="plain-text" placeholder="Message" aria-label="Recipient's username" aria-describedby="basic-addon2">
							<div class="input-group-append">
								<button class="btn btn-outline-success mr-3 submit-button" type="submit"><i class="fi fi-rs-paper-plane"></i>&nbsp&nbsp {{ __('Sent') }}</button>
							</div>
						</div>
					</form>				
			</div>
			@else
			<div class="col-sm-12">
				<div class="alert bg-gradient-primary text-white alert-dismissible fade show" role="alert">
					<span class="alert-icon"><i class="fi  fi-rs-info text-white"></i></span>
					<span class="alert-text">
						<strong>{{ __('!Opps ') }}</strong> 

						{{ __('Chat list access features is not available in your subscription plan') }}

					</span>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
<input type="hidden" id="uuid" value="{{$device->uuid}}">
<input type="hidden" id="base_url" value="{{ url('/') }}">
@endsection
@if(getUserPlanData('access_chat_list') == true)
@push('js')
<script type="text/javascript" src="{{ asset('assets/js/pages/chat/list.js') }}"></script>
@endpush
@endif