@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Edit Gateway'),
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
		<strong>{{ __('Edit Payment Gateway') }}</strong>
		<p>{{ __('Edit gateway information for accepting payment') }}</p>
	</div>
	<div class="col-lg-7 mt-5">
		<form class="ajaxform_instant_reload" action="{{ route('admin.gateways.update',$gateway->id) }}">
			@csrf
			@method('PUT')
			<div class="card">
				<div class="card-body">
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="name">{{ __('Gateway Name') }}</label>
						<input type="text" class="form-control" name="name" id="name" value="{{ $gateway->name }}" required>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="logo">{{ __('Logo') }}</label>
						<input type="file" id="logo" class="form-control" name="logo">
						@if ($gateway->logo != '')
						<img src="{{ asset($gateway->logo) }}" height="30" alt="" class="image-thumbnail mt-2">
						@endif
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="currency">{{ __('Currency') }}</label>
						<input type="text" class="form-control" name="currency" id="currency" value="{{ $gateway->currency }}" required>
					</div>
					@if($gateway->is_auto == 1)
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="sandbox">{{ __('Sandbox Mode') }}</label>
						<select class="form-control selectric" name="test_mode" id="sandbox">
							<option value="1" {{ $gateway->test_mode == 1 ? 'selected' : '' }}>{{ __('Enable') }}</option>
							<option value="0" {{ $gateway->test_mode == 0 ? 'selected' : '' }}>{{ __('Disable') }}</option>
						</select>
					</div>
					@endif
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="min_amount">{{ __('Minimum Amount') }}</label>
						<input type="number" name="min_amount" id="min_amount" step="any" value="{{ $gateway->min_amount }}" class="form-control" placeholder="{{ __("Minimum transaction amount") }}" required>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="max_amount">{{ __('Maximum Amount') }}</label>
						<input type="number" name="max_amount" id="max_amount" step="any" value="{{ $gateway->max_amount }}" class="form-control" placeholder="{{ __("Maximum transaction amount") }}" required>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="charge">{{ __('Charge') }}</label>
						<input type="text" class="form-control" name="charge" id="charge" value="{{ $gateway->charge ?? 0 }}" required>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="multiply">{{ __('Multiply from base currency') }}</label>
						<input type="number" step="any" class="form-control" name="multiply" id="multiply"  value="{{ $gateway->multiply ?? 0 }}"  required value="0">
					</div>
					@if($gateway->is_auto == 1)
					@php 
					   $data = json_decode($gateway->data ?? '')
					@endphp
					 @foreach ($data ?? [] as $key => $value)
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="status">{{ ucwords(str_replace("_", " ", $key)) }}</label>
						<input type="text" class="form-control" name="data[{{ $key }}]" value="{{ $value }}">
					</div>
					 @endforeach
					@endif

					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="status">{{ __('Payment Instruction') }}</label>
						<textarea class="form-control" maxlength="1000" name="comment">{{ $gateway->comment }}</textarea>
					</div>
					<div class="form-group mb-4">
						<label class="col-form-label text-md-right required" for="status">{{ __('Status') }}</label>
						<select class="form-control selectric" name="status" id="status">
							<option value="1" {{ $gateway->status == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
							<option value="0" {{ $gateway->status == 0 ? 'selected' : '' }}>{{ __('Deactivate') }}</option>
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