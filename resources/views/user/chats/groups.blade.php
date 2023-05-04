@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title' => __('Group List'),
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
			@if(getUserPlanData('access_group_list') == true)
			<div class="col-sm-12 server_disconnect text-center none">
				<img src="{{ asset('/uploads/disconnect.webp') }}" class="w-50" height="80%"><br>
				<div class="row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<div class="alert bg-gradient-red  text-white" role="alert">
							{{ __('Opps! Server Disconnected 😭') }}
						</div>
					</div>
					<div class="col-sm-3"></div>
				</div>
			</div>
			<div class="col-sm-4 main-area" >
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
				<ul class="list-group list-group-flush list my--3 contact-list mt-5 position-relative">
				</ul>
			</div>
			<div class="col-sm-8 mt-5 main-area" >
				<div class="text-center">
					<img src="{{ asset('assets/img/whatsapp-bg.png') }}" class="wa-bg-img">
					<h3>{{ __('Sent message to group') }}</h3>
				</div>
				<form method="post" class="ajaxform" action="{{ route('user.group.send-message',$device->uuid) }}">
					@csrf
					<input type="hidden" name="group" class="reciver-id">

					<div class="form-group mb-5  none sendble-row">
						<label>{{ __('Target Group Name') }}</label>
						<input type="text" readonly="" name="group_name" class="form-control bg-white reciver-group">
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

						{{ __('Group access features is not available in your subscription plan') }}

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
@if(getUserPlanData('access_group_list') == true)
@push('js')
<script type="text/javascript" src="{{ asset('assets/js/pages/chat/groups.js') }}"></script>
@endpush
@endif