@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Create a feature'),
'buttons'=>[
	[
		'name'=>__('Back'),
		'url'=>route('admin.features.index'),
	]
 ]
])
@endsection
@section('content')
<form class="ajaxform_instant_reload" method="post" action="{{ route('admin.features.update',$info->id) }}" enctype="multipart/form-data">
	@csrf
	@method("PUT")
	<div class="row">
		<div class="col-lg-5">
			<strong>{{ __('Edit features post') }}</strong>
			<p>{{ __('Edit your features post details and necessary information from here') }}</p>
		</div>

		<div class="col-lg-7">
			<div class="card">
				<div class="card-body">
					<div class="from-group row">
						<label  class="col-lg-12">{{ __('Features Title') }}</label>
						<div class="col-lg-12">
							<input type="text" name="title" required="" class="form-control" value="{{ $info->title }}">
						</div>
					</div>
				
					<div class="from-group row  mt-2">
						<label  class="col-lg-12">{{ __('Preview Image') }}</label>
						<div class="col-lg-12">
							<input type="file" class="form-control"  name="preview_image" accept="image/*">
						</div>
					</div>
					<div class="from-group row  mt-2">
						<label  class="col-lg-12">{{ __('Banner Image') }}</label>
						<div class="col-lg-12">
							<input type="file" class="form-control"  name="banner_image" accept="image/*">
						</div>
					</div>
					<div class="from-group row mt-2">
						<label  class="col-lg-12">{{ __('Short Description') }}</label>
						<div class="col-lg-12">
							<textarea name="description" required="" class="form-control h-100" maxlength="500">{{ $info->excerpt->value ?? '' }}</textarea>
						</div>
					</div>
					<div class="from-group row mt-3">
						<label  class="col-lg-12">{{ __('Main Description') }}</label>
						<div class="col-lg-12">
							<textarea name="main_description" required="" class="h-200 form-control">{{ $info->longDescription->value ?? '' }}</textarea>
						</div>
					</div>
					<div class="from-group row  mt-2">
						<label  class="col-lg-12">{{ __('Select Langauge') }}</label>
						<div class="col-lg-12">
							<select name="language" class="form-control" >
								@foreach ($languages ?? [] as $languagesKey => $language)
								<option value="{{ $languagesKey }}" {{ $info->lang == $languagesKey ? 'selected' : '' }}> {{ $language }} </option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="from-group row  mt-2">
						<div class="col-lg-12 d-flex">
							<label class="custom-toggle custom-toggle-primary">
								<input type="checkbox"  name="featured" value="1" id="plain-text-with-featured"  data-target=".plain-title-with-featured" class="save-template"  {{ $info->featured == 1 ? 'checked' : ''  }}>
								<span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
							</label>
							<label class="mt-1 ml-1" for="plain-text-with-featured"><h4>{{ __('Make it featured?') }}</h4></label>
						</div>
						<div class="col-lg-12 d-flex">
							<label class="custom-toggle custom-toggle-primary">
								<input type="checkbox"  name="status" value="1" id="plain-text-with-button"  data-target=".plain-title-with-button" class="save-template" {{ $info->status == 1 ? 'checked' : ''  }}>
								<span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
							</label>
							<label class="mt-1 ml-1" for="plain-text-with-button"><h4>{{ __('Make it publish?') }}</h4></label>
						</div>
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
