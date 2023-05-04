@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title' => __('Create Support Ticket'),
'buttons'=>[
	[
		'name'=>'Back',
		'url'=> route('user.support.index'),
	]
]])
@endsection
@section('content')
<div class="row justify-content-center">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('Create Ticket') }}</h4>
			</div>
			<div class="card-body">
				<form method="POST" class="ajaxform_instant_reload" action="{{ route('user.support.store') }}">
					@csrf				
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Subject') }}</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="subject" maxlength="100" required="" class="form-control">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Message') }}</label>
					<div class="col-sm-12 col-md-7">
						<textarea class="form-control h-200" name="message" required="" maxlength="1000"></textarea>
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