@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'   => __('Edit Profile'),
'buttons' =>[
	[
		'name'=> __('Back to dashboard'),
		'url'=> url('user/dashboard'),
	]
]])
@endsection
@section('content')
<div class="row ">
	<div class="col-lg-5 mt-5">
        <strong>{{ __('Authentication Key') }}</strong>
        <p>{{ __('Use auth key for authenticate your api request') }}</p>
    </div>
    <div class="col-lg-7 mt-5">
        <form class="ajaxform_instant_reload" action="{{ route('user.profile.update','auth-key') }}">
        	@csrf
        	@method('PUT')
        	<div class="card">
            <div class="card-body">
               
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Auth API Key') }}</label>
                    <div class="col-lg-12">
                        <input type="text" name="authket" required="" class="form-control" value="{{ Auth::user()->authkey }}" disabled="">
                    </div>
                </div>
                 <div class="from-group row mt-3">
                    <div class="col-lg-12">
                       <button class="btn btn-neutral submit-button btn-sm float-left"> {{ __('Regenerate Auth Key') }}</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection