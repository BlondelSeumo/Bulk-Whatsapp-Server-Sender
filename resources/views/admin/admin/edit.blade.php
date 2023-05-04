@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Edit Admin'),
'buttons'=>[
    [
        'name'=>__('Back'),
        'url'=>route('admin.admin.index'),
    ]
]

])
@endsection
@section('content')
<div class="row">
	<div class="col-lg-5 mt-5">
        <strong>{{ __('Edit Admin') }}</strong>
        <p>{{ __('edit admin profile information') }}</p>
    </div>
    <div class="col-lg-7 mt-5">     
		<div class="card">
			<div class="card-body">
				<form method="post" action="{{ route('admin.admin.update',$user->id) }}" class="ajaxform">
					@csrf
					@method("PUT")
					<div class="pt-20">
						<div class="form-group">
							<label for="name">{{ __('Name') }}</label>
							<input type="text" placeholder="Enter Name" name="name" class="form-control" id="name" required="" value="{{ $user->name }}" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="email">{{ __('Email') }}</label>
							<input type="email" placeholder="Enter Email" name="email" class="form-control" id="email" required="" value="{{ $user->email }}" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="password">{{ __('Password') }}</label>
							<input type="password" placeholder="Enter password" name="password" class="form-control" id="password"  autocomplete="off">
						</div>
						<div class="form-group">
							<label for="password_confirmation">{{ __('Password') }}</label>
							<input type="password" placeholder="Confirm Password" name="password_confirmation" class="form-control" id="password_confirmation" value="" autocomplete="off">
						</div>

						<div class="form-group">
                            <label for="roles">{{ __('Assign Roles') }}</label>
                                <select required name="roles[]" id="roles" class="form-control select2" multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <div class="form-group">
                        <label>{{ __('Status') }}</label>
                        <select name="status" class="form-control">
                            <option value="1" @if($user->status==1) selected @endif> {{ __('Active') }}</option>
                            <option value="0"  @if($user->status==0) selected @endif> {{ __('Deactive') }}</option>

                        </select>
                        </div>
						
					</div>
				</div>
				<div class="card-footer">
					<div class="btn-publish">
							<button type="submit" class="btn btn-neutral submit-button"><i class="fa fa-save"></i> {{ __('Save') }}</button>
						</div>
				</div>
			</div>

		</div>
		
	</form>
@endsection