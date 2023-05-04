@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['buttons'=>[
	[
		'name'=>'Back',
		'url'=> route('user.contact.index'),
	]
]])
@endsection
@section('content')
<div class="row justify-content-center">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('Create Contact') }}</h4>
			</div>
			<div class="card-body">
				<form method="POST" class="ajaxform_reset_form" action="{{ route('user.contact.store') }}">
					@csrf				
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('User Name') }}</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="name" placeholder="Jhone Doe" maxlength="50" class="form-control">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Whatsapp Number') }}</label>
					<div class="col-sm-12 col-md-7">
						<input type="number" name="phone" placeholder="{{ __('Enter Phone Number With Country Code') }}" maxlength="15" class="form-control">
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