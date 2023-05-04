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
        <strong>{{ __('Application Settings') }}</strong>
        <p>{{ __('Edit you application global settings') }}</p>
    </div>
    <div class="col-lg-7 mt-5">
        <form class="ajaxform" action="{{ route('admin.developer-settings.update',$id) }}">
        	@csrf
        	@method('PUT')
        	<div class="card">
            <div class="card-body">
                <div class="from-group row">
                    <label class="col-lg-12">{{ __('Application Name') }}</label>
                    <div class="col-lg-12">
                        <input type="text" name="name"  value="{{ env('APP_NAME') }}" required="" class="form-control">
                    </div>
                </div> 
                
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Visibility Of Site Error') }}</label>
                    <div class="col-lg-12">
                        <select class="form-control" name="app_debug">
                            <option value="true" {{ env('APP_DEBUG') == true ? 'selected' : '' }}>{{ __('Enable') }}</option>
                            <option value="false" {{ env('APP_DEBUG') == false ? 'selected' : '' }}>{{ __('Disable') }}</option>
                        </select>
                    </div>
                </div>   
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Application Time Zone') }}</label>
                    <div class="col-lg-12">
                        <select class="form-control" name="timezone">
                            @foreach($tzlist as $timezone)
                            <option value="{{ $timezone }}" {{ env('TIME_ZONE') == $timezone ? 'selected' : '' }}>{{ $timezone }}</option>
                            @endforeach                            
                        </select>
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Application Default Language') }}</label>
                    <div class="col-lg-12">
                        <select class="form-control" name="default_lang">
                            @foreach($languages ?? [] as $langKey => $langauge)
                            <option value="{{ $langKey }}" {{ env('DEFAULT_LANG') == $langKey ? 'selected' : '' }}>{{ $langauge }}</option>
                            @endforeach                            
                        </select>
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