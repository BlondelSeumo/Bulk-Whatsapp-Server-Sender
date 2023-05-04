@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'   => __('Edit Profile'),
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
        <strong>{{ __('General Settings') }}</strong>
        <p>{{ __('Edit you basic credentials') }}</p>
    </div>
    <div class="col-lg-7 mt-5">
        <form class="ajaxform" action="{{ route('admin.profile.update','general') }}" enctype="multipart/form-data">
        	@csrf
        	@method('PUT')
        	<div class="card">
            <div class="card-body">
                <div class="from-group row">
                    <label class="col-lg-12">{{ __('Name') }}</label>
                    <div class="col-lg-12">
                        <input type="text" name="name" required="" class="form-control" value="{{ Auth::user()->name }}">
                    </div>
                </div>     
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Email') }}</label>
                    <div class="col-lg-12">
                       <input type="email" name="email" required="" class="form-control" value="{{ Auth::user()->email }}">
                    </div>
                </div>
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Phone') }}</label>
                    <div class="col-lg-12">
                        <input type="text" name="phone" required="" class="form-control" value="{{ Auth::user()->phone }}">
                    </div>
                </div>
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Address (will used for invoice)') }}</label>
                    <div class="col-lg-12">
                        <input type="text" name="address" required="" class="form-control" value="{{ Auth::user()->address }}">
                    </div>
                </div>
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Avatar') }}</label>
                    <div class="col-lg-12">
                        <input type="file" name="avatar"  class="form-control" accept="image/*">
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
<div class="row ">
	<div class="col-lg-5">
        <strong>{{ __('Password') }}</strong>
        <p>{{ __('Change Your Password') }}</p>
    </div>
    <div class="col-lg-7">
    	<form class="ajaxform_reset_form" action="{{ route('admin.profile.update','password') }}">
    		@csrf
    		@method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="from-group row">
                    <label class="col-lg-12">{{ __('Old Password') }}</label>
                    <div class="col-lg-12">
                        <input type="password" name="oldpassword" required="" class="form-control">
                    </div>
                </div>     
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('New Password') }}</label>
                    <div class="col-lg-12">
                       <input type="password" name="password" required="" class="form-control">
                    </div>
                </div>
                <div class="from-group row mt-2">
                    <label class="col-lg-12">{{ __('Confirm Password') }}</label>
                    <div class="col-lg-12">
                        <input type="password" name="password_confirmation" required="" class="form-control">
                    </div>
                </div>
                 <div class="from-group row mt-3">
                    <div class="col-lg-12">
                       <button class="btn btn-neutral submit-button btn-sm float-left">{{ __('Update Password') }}</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

@endsection