@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Edit Team Member profile'),
'buttons'=>[
	[
		'name'=>__('Back'),
		'url'=>route('admin.team.index'),
	]
 ]
])
@endsection

@section('content')
<form class="ajaxform" method="post" action="{{ route('admin.team.update',$info->id) }}" enctype="multipart/form-data">
	@csrf
	@method('PUT')
	
	<div class="row">
		<div class="col-lg-5">
			<strong>{{ __('Edit team member') }}</strong>
			<p>{{ __('Edit your team member details and necessary information from here') }}</p>
		</div>
		<div class="col-lg-7 card-wrapper">
			<!-- Alerts -->
			<div class="card">
				<div class="card-header">
					<h3 class="mb-0">{{ __('Edit Team Member bio') }}</h3>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>{{ __('Member Name') }}</label>
						<input type="text" name="member_name" value="{{ $info->title }}" required="" class="form-control">
					</div>
					<div class="form-group">
						<label>{{ __('Member Position') }}</label>
						<input type="text" name="member_position" value="{{ $info->slug }}" required="" class="form-control">
					</div>
					<div class="form-group">
						<label>{{ __('Profile Picture') }}</label>
						<input type="file" accept="image/*" name="profile_picture"  class="form-control">
					</div>
					

					<div class="form-group">
						<label>{{ __('Profile Description') }}</label>
						<textarea class="form-control h-200" name="about" maxlength="1000" required="">{{ $info->description->value ?? '' }}</textarea>
					</div>
					<div class="form-group">
						<label>{{ __('Facebook profile link') }}</label>
						<input type="url" name="socials[facebook]" value="{{ $socials->facebook ?? '' }}" class="form-control">
					</div>
					<div class="form-group">
						<label>{{ __('Twitter profile link') }}</label>
						<input type="url" name="socials[twitter]" value="{{ $socials->twitter ?? '' }}" class="form-control">
					</div>
					<div class="form-group">
						<label>{{ __('Linkedin profile link') }}</label>
						<input type="url" name="socials[linkedin]" value="{{ $socials->linkedin ?? '' }}" class="form-control">
					</div>
					<div class="form-group">
						<label>{{ __('Instagram profile link') }}</label>
						<input type="url" name="socials[instagram]" value="{{ $socials->instagram ?? '' }}" class="form-control">
					</div>
					<div class="d-flex">
						<label class="custom-toggle custom-toggle-primary">
							<input type="checkbox"  name="status" value="1" id="plain-text-with-button"   data-target=".plain-title-with-button" class="save-template" {{ $info->status == 1 ? 'checked' : '' }} >
							<span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
						</label>
						<label class="mt-1 ml-1" for="plain-text-with-button"><h4>{{ __('Make it publish?') }}</h4></label>
					</div>

					<div class="from-group row mt-3">
						<div class="col-lg-12">
							<button class="btn btn-neutral submit-button">{{ __('Submit') }}</button>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div>
</form>
@endsection