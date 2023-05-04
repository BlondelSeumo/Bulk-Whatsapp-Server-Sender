@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'   => __('SMTP Settings'),
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
        <strong>{{ __('SMTP mail Settings') }}</strong>
        <p>{{ __('Edit you smtp settings for mail transaction') }}</p>
    </div>
    <div class="col-lg-7 mt-5">
        <form class="ajaxform" action="{{ route('admin.developer-settings.update',$id) }}">
        	@csrf
        	@method('PUT')
        	<div class="card">
            <div class="card-body">
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Use Queue Job For Mail Transaction?') }}</label>
                    <div class="col-lg-12">
                     <select name="QUEUE_MAIL" class="form-control">
                        <option value="true" @selected(env('QUEUE_MAIL') == true)>{{ __('Enable') }}</option>
                        <option value="false" @selected(env('QUEUE_MAIL') == false)>{{ __('Disable') }}</option>
                      </select>
                    </div>
                </div>
                <div class="from-group row">
                    <label class="col-lg-12">{{ __('Mail driver type') }}</label>
                    <div class="col-lg-12">
                        <select name="MAIL_DRIVER_TYPE" class="form-control">
                            <option value="MAIL_MAILER" @if(env('MAIL_DRIVER_TYPE') == 'MAIL_MAILER') selected="" @endif>{{ __('MAIL MAILER') }}</option>
                            <option value="MAIL_DRIVER" @if(env('MAIL_DRIVER_TYPE') == 'MAIL_DRIVER') selected="" @endif>{{ __('MAIL DRIVER') }}</option>
                        </select>
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Mail Driver') }}</label>
                    <div class="col-lg-12">
                     <select name="MAIL_DRIVER" class="form-control">
                        <option value="sendmail" @selected($mailDriver == 'sendmail')>{{ __('sendmail') }}</option>
                        <option value="smtp" @selected($mailDriver == 'smtp')>{{ __('smtp') }}</option>
                      </select>
                    </div>
                </div>                
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Mail Host') }}</label>
                    <div class="col-lg-12">
                     <input type="text"   name="MAIL_HOST" class="form-control" required="" value="{{ env('MAIL_HOST') }}">
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Mail Port') }}</label>
                    <div class="col-lg-12">
                     <input type="text"   name="MAIL_PORT" class="form-control" required="" value="{{ env('MAIL_PORT') }}">
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Mail Username') }}</label>
                    <div class="col-lg-12">
                     <input type="text"   name="MAIL_USERNAME" class="form-control" required="" value="{{ env('MAIL_USERNAME') }}">
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Mail Password') }}</label>
                    <div class="col-lg-12">
                     <input type="text"   name="MAIL_PASSWORD" class="form-control" required="" value="{{ env('MAIL_PASSWORD') }}">
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Mail Encryption') }}</label>
                    <div class="col-lg-12">
                     <select name="MAIL_ENCRYPTION" class="form-control">
                        <option value="ssl" @selected(env('MAIL_ENCRYPTION') == 'ssl')>{{ __('SSL') }}</option>
                        <option value="tls" @selected(env('MAIL_ENCRYPTION') == 'tls')>{{ __('TLS') }}</option>
                      </select>
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Mail From Address') }}</label>
                    <div class="col-lg-12">
                     <input type="email"   name="MAIL_FROM_ADDRESS" class="form-control" placeholder="email" required="" value="{{ env('MAIL_FROM_ADDRESS') }}">
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Mail From Name') }}</label>
                    <div class="col-lg-12">
                     <input type="text"   name="MAIL_FROM_NAME" class="form-control" placeholder="Website Name" required="" value="{{ env('MAIL_FROM_NAME') }}">
                    </div>
                </div> 
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Incoming Mail') }}</label>
                    <div class="col-lg-12">
                     <input type="email"   name="MAIL_TO" class="form-control" placeholder="email" required="" value="{{ env('MAIL_TO') }}">
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