@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['title'=> __('Cron Jobs')])
@endsection
@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('Execute Schedule Messages') }}</h4>
			</div>
			<div class="card-body">
				<div class="code"><p class="text-white">curl -s {{ url('/cron/execute-schedule') }}</p></div>
				<br>
				<strong>{{ __('Everyday') }}</strong>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('Notify to customer before expire the subscription') }}</h4>
			</div>
			<div class="card-body">
				<div class="code"><p class="text-white">curl -s {{ url('/cron/notify-to-user') }}</p></div>
				<br>
				<strong>{{ __('Everyday') }}</strong>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('Remove Junk Devices') }}</h4>
			</div>
			<div class="card-body">
				<div class="code"><p class="text-white">curl -s {{ url('/cron/remove-junk-device') }}</p></div>
				<br>
				<strong>{{ __('Everyday') }}</strong>
			</div>
		</div>
	</div>
</div>
@endsection