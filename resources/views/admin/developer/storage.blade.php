@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'   => __('Storage Settings'),
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
        <strong>{{ __('Application Storage Settings') }}</strong>
        <p>{{ __('Edit you storage settings for store uploaded files') }}</p>
    </div>
    <div class="col-lg-7 mt-5">
        <form class="ajaxform" action="{{ route('admin.developer-settings.update',$id) }}">
        	@csrf
        	@method('PUT')
        	<div class="card">
            <div class="card-body">
                <div class="from-group row">
                    <label class="col-lg-12">{{ __('Storage Upload Mode') }}</label>
                    <div class="col-lg-12">
                       <select class="form-control" name="FILESYSTEM_DISK" id="disk-method">
                           <option value="public" {{ env('FILESYSTEM_DISK') == 'public' ? 'selected' : '' }}>{{ __('Own server (Uploads folder)') }}</option>
                           <option value="wasabi" {{ env('FILESYSTEM_DISK') == 'wasabi' ? 'selected' : '' }}>{{ __('Wasabi') }}</option>
                       </select>
                    </div>
                </div> 
                
                <div class="wasabi {{ env('FILESYSTEM_DISK') == 'public' ? 'none' : '' }}">
                    <div class="from-group row mt-2">
                        <label class="col-lg-12">{{ __('Wasabi Access Key Id') }}</label>
                        <div class="col-lg-12">
                           <input type="text" name="WAS_ACCESS_KEY_ID" class="form-control" value="{{ env('WAS_ACCESS_KEY_ID') }}">
                        </div>
                    </div> 
                    <div class="from-group row mt-2">
                        <label class="col-lg-12">{{ __('Wasabi Secret Access Key') }}</label>
                        <div class="col-lg-12">
                           <input type="text" name="SECRET_ACCESS_KEY" class="form-control" value="{{ env('SECRET_ACCESS_KEY') }}">
                        </div>
                    </div> 
                    <div class="from-group row mt-2">
                        <label class="col-lg-12">{{ __('Wasabi Default Region') }}</label>
                        <div class="col-lg-12">
                           <input type="text" name="WAS_DEFAULT_REGION" class="form-control" value="{{ env('WAS_DEFAULT_REGION') }}">
                        </div>
                    </div> 
                    <div class="from-group row mt-2">
                        <label class="col-lg-12">{{ __('Wasabi Bucket Name') }}</label>
                        <div class="col-lg-12">
                           <input type="text" name="WAS_BUCKET" class="form-control" value="{{ env('WAS_BUCKET') }}">
                        </div>
                    </div> 
                    <div class="from-group row mt-2">
                        <label class="col-lg-12">{{ __('Wasabi Endpoint') }}</label>
                        <div class="col-lg-12">
                           <input type="text" name="WAS_ENDPOINT" class="form-control" value="{{ env('WAS_ENDPOINT') }}">
                        </div>
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