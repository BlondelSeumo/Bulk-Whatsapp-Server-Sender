@extends('layouts.main.app')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}">
@endpush
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Create a blog'),
'buttons'=>[
	[
		'name'=>__('Back'),
		'url'=>route('admin.blog.index'),
	]
 ]
])
@endsection
@section('content')
<form class="ajaxform_instant_reload" method="post" action="{{ route('admin.blog.store') }}">
	@csrf
	<div class="row justify-content-center">
		

		<div class="col-lg-10">
			<div class="card">
				<div class="card-body">
					<div class="from-group row">
						<label  class="col-lg-12">{{ __('Blog Title') }}</label>
						<div class="col-lg-12">
							<input type="text" name="title" required="" class="form-control">
						</div>
					</div>
					
					<div class="from-group row  mt-2">
						<label  class="col-lg-12">{{ __('Blog Image (Preview)') }}</label>
						<div class="col-lg-12">
							<input type="file" class="form-control" required="" name="preview" accept="image/*">
						</div>
					</div>
					<div class="from-group row mt-2">
						<label  class="col-lg-12">{{ __('Short Description') }}</label>
						<div class="col-lg-12">
							<textarea name="short_description" required="" class="form-control h-100" maxlength="500"></textarea>
						</div>
					</div>
					<div class="from-group row mt-3">
						<label  class="col-lg-12">{{ __('Main Description') }}</label>
						<div class="col-lg-12">
							<textarea name="main_description" required="" class="summernote form-control"></textarea>
						</div>
					</div>
					<div class="from-group row  mt-2">
						<label  class="col-lg-12">{{ __('Select Category') }}</label>
						<div class="col-lg-12">
							<select name="categories[]" class="form-control select2" multiple="">
								@foreach ($categories ?? [] as $key => $category)
								<option value="{{ $key }}"> {{ __($category) }} </option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="from-group row  mt-2">
						<label  class="col-lg-12">{{ __('Select Tags') }}</label>
						<div class="col-lg-12">
							<select name="categories[]" class="form-control select2" multiple="">
								@foreach ($tags as $key => $tag)
								<option value="{{ $key }}"> {{ __($tag) }} </option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="from-group row  mt-2">
						<label  class="col-lg-12">{{ __('Select Langauge') }}</label>
						<div class="col-lg-12">
							<select name="language" class="form-control" >
								@foreach ($languages ?? [] as $languagesKey => $language)
								<option value="{{ $languagesKey }}"> {{ $language }} </option>
								@endforeach
							</select>
						</div>
					</div>

					<hr>

					<div class="from-group row mt-3">
						<label  class="col-lg-12">{{ __('SEO Meta Title') }}</label>
						<div class="col-lg-12">
							<input type="text" name="meta_title" required="" class="form-control">
						</div>
					</div>     
					<div class="from-group row  mt-2">
						<label  class="col-lg-12">{{ __('SEO Meta Image') }}</label>
						<div class="col-lg-12">
							<input type="file" class="form-control" name="meta_image" required="" accept="image/*">
						</div>
					</div>
					<div class="from-group row mt-2">
						<label  class="col-lg-12">{{ __('SEO Meta Description') }}</label>
						<div class="col-lg-12">
							<textarea name="meta_description" required="" class="form-control h-100"></textarea>
						</div>
					</div>
					<div class="from-group row mt-2">
						<label  class="col-lg-12">{{ __('SEO Meta Tags') }}</label>
						<div class="col-lg-12">
							<input type="text" name="meta_tags" required="" class="form-control">
						</div>
					</div>

					<div class="from-group row  mt-3">
						<div class="col-lg-12 d-flex">
							
							<label class="custom-toggle custom-toggle-primary">
								<input type="checkbox"  name="featured" value="1" id="plain-text-with-featured"  data-target=".plain-title-with-featured" class="save-template">
								<span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
							</label>
							<label class="mt-1 ml-1" for="plain-text-with-featured"><h4>{{ __('Make it featured?') }}</h4></label>

							
						</div>
						<div class="col-lg-12 d-flex">
							<label class="custom-toggle custom-toggle-primary">
								<input type="checkbox"  name="status" value="1" id="plain-text-with-button"  data-target=".plain-title-with-button" class="save-template">
								<span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
							</label>
							<label class="mt-1 ml-1" for="plain-text-with-button"><h4>{{ __('Make it publish?') }}</h4></label>
						</div>
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
@push('js')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/summernote/summernote-bs4.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/summernote/summernote.js') }}"></script>
@endpush