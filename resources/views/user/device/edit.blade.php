@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['buttons'=>[
	[
		'name'=>'<i class="ni ni-curved-next"></i> Back',
		'url'=> route('user.device.index'),
	]
]])
@endsection
@section('content')

<div class="row justify-content-center">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('Edit Device') }}</h4>
			</div>
			<div class="card-body">
				<form method="POST" class="ajaxform_instant_reload" action="{{ route('user.device.update',$device->uuid) }}">
					@csrf
					@method('PUT')
				
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Device Name') }}</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="name" placeholder="My Iphone 13 Pro" value="{{ $device->name }}" class="form-control">
					</div>
				</div>
				
								
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
					<div class="col-sm-12 col-md-7">
						<button type="submit" class="btn btn-outline-primary submit-btn">{{ __('Save Now') }}</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection