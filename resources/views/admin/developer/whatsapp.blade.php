@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'   => __('App Settings'),
'buttons' =>[
	[
		'name'=> __('Back to dashboard'),
		'url'=> url('admin/dashboard'),
	]
]])
@endsection
@section('content')
<div class="row ">
	<div class="col-lg-5 mt-5">
        <strong>{{ __('Whatsapp Server Settings') }}</strong>
        <p>{{ __('Edit you Whatsapp server settings') }}</p>
    </div>
    <div class="col-lg-7 mt-5">
        <form class="ajaxform" action="{{ route('admin.developer-settings.update',$id) }}">
        	@csrf
        	@method('PUT')
        	<div class="card">
            <div class="card-body">
                
               

               
                 <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Whatsapp Server Url') }}</label>
                    <div class="col-lg-12">
                        <input type="text" name="wa_server_url"  value="{{ env('WA_SERVER_URL') }}" required="" class="form-control">
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Whatsapp Server Host') }}</label>
                    <div class="col-lg-12">
                        <input type="text" name="host"  value="{{ env('WA_SERVER_HOST') }}" required="" class="form-control">
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Whatsapp Server Port') }}</label>
                    <div class="col-lg-12">
                        <input type="text" name="port"  value="{{ env('WA_SERVER_PORT') }}" required="" class="form-control">
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Max Retties') }}</label>
                    <div class="col-lg-12">
                        <input type="number" name="MAX_RETRIES"  value="{{ env('WA_SERVER_MAX_RETRIES') }}" required="" class="form-control">
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Reconnect Interval') }}</label>
                    <div class="col-lg-12">
                        <input type="number" name="reconnect_interval"  value="{{ env('WA_SERVER_RECONNECT_INTERVAL') }}" required="" class="form-control">
                    </div>
                </div> 
               
                              
                <div class="from-group row mt-3">
                    <div class="col-lg-12">
                       <button class="btn btn-neutral submit-button btn-sm float-left">{{ __('Update Settings') }}</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection