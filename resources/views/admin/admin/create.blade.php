@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Create admin'),
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
        <strong>{{ __('Create Admin') }}</strong>
        <p>{{ __('add admin profile information') }}</p>
    </div>
    <div class="col-lg-7 mt-5">     
		<div class="card">
			<div class="card-body">
				<form method="post" action="{{ route('admin.admin.store') }}" class="ajaxform_instant_reload">
					@csrf
					<div class="pt-20">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" placeholder="Enter Name" name="name" class="form-control" id="name" required="" value="" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" placeholder="Enter Email" name="email" class="form-control" id="email" required="" value="" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" placeholder="Enter password" name="password" class="form-control" id="password" required="" value="" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="password_confirmation">Password</label>
							<input type="password" placeholder="Confirm Password" name="password_confirmation" class="form-control" id="password_confirmation" required="" value="" autocomplete="off">
						</div>

						<div class="form-group">
							<label >Assign Roles</label>
							<select required name="roles[]" id="roles" class="form-control select2" multiple>
								@foreach ($roles as $role)
								<option value="{{ $role->name }}">{{ $role->name }}</option>
								@endforeach
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