@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['buttons'=>[
	[
		'name'=>'Back',
		'url'=> route('user.device.index'),
	]
]])
@endsection
@section('content')

@if(Session::has('new-user'))
<div class="row justify-content-center">
	<div class="col-sm-12">
		<div class="alert bg-gradient-primary text-white alert-dismissible fade show success-alert" role="alert">
			<span class="alert-text"><strong>{{ __('Hi. ').Auth::user()->name }}</strong> {{ __('Welcome to ').env('APP_NAME') }} {{ Session::get('new-user') }}</span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	</div>  
	@endif    
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('Create Device') }}</h4>
			</div>
			<div class="card-body">
				<form method="POST" class="ajaxform_instant_reload" action="{{ route('user.device.store') }}">
					@csrf
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Device Name') }}</label>
						<div class="col-sm-12 col-md-7">
							<input type="text" name="name" placeholder="My Iphone 13 Pro" class="form-control">
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
						<div class="col-sm-12 col-md-7">
							<button type="submit" class="btn btn-outline-primary submit-btn">{{ __('Create Now') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection