@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Create Gateway'),
'buttons'=>[
	[
		'name'=>__('Back'),
		'url'=>route('admin.gateways.index'),
	]
]])
@endsection
@section('content')
<div class="row ">
	<div class="col-lg-5 mt-5">
		<strong>{{ __('Create Payment Gateway') }}</strong>
		<p>{{ __('Create manual payment gateway for accepting payment') }}</p>
	</div>
	<div class="col-lg-7 mt-5">
		<form class="ajaxform_instant_reload" action="{{ route('admin.gateways.store') }}" enctype="multipart/form-data">
			@csrf
			<div class="card">
				<div class="card-body">
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="name">{{ __('Gateway Name') }}</label>
						<input type="text" class="form-control" name="name" id="name"  required>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="logo">{{ __('Logo') }}</label>
						<input type="file" id="logo" class="form-control" name="logo" accept="image/*">
												
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="currency">{{ __('Currency') }}</label>
						<input type="text" class="form-control" name="currency" id="currency"  required>
					</div>
					
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="min_amount">{{ __('Minimum Amount') }}</label>
						<input type="number" name="min_amount" id="min_amount" step="any"  class="form-control" placeholder="{{ __("Minimum transaction amount") }}" required>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="max_amount">{{ __('Maximum Amount') }}</label>
						<input type="number" name="max_amount" id="max_amount" step="any"  class="form-control" placeholder="{{ __("Maximum transaction amount") }}" required>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="charge">{{ __('Gateway Charge') }}</label>
						<input type="number" step="any" class="form-control" name="charge" id="charge"  required value="0">
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="multiply">{{ __('Multiply from base currency') }}</label>
						<input type="number" step="any" class="form-control" name="multiply" id="multiply"  required value="0">
					</div>
					
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="status">{{ __('Payment Instruction') }}</label>
						<textarea class="form-control" maxlength="1000" name="comment"></textarea>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="status">{{ __('Status') }}</label>
						<select class="form-control selectric" name="status" id="status">
							<option value="1" >{{ __('Active') }}</option>
							<option value="0" >{{ __('Deactivate') }}</option>
						</select>
					</div>
					<div class="form-group mb-4">
						<button class="btn btn-neutral submit-button">{{ __('Update') }}</button>
					</div>	
				</div>
			</div>
		</form>
	</div>
</div>


@endsection