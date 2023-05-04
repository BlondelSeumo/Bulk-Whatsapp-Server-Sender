@extends('layouts.main.app')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}">
@endpush
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Edit Page'),
'buttons'=>[
	[
		'name'=>__('Back'),
		'url'=>route('admin.page.index'),
	]
]
])
@endsection
@section('content')
<form class="ajaxform_instant_reload" method="post" action="{{ route('admin.page.update',$info->id) }}">
	@csrf
	@method('PUT')
	
	<div class="row justify-content-center">
		<div class="col-lg-10 card-wrapper">
			<!-- Alerts -->
			<div class="card">
				<div class="card-header">
					<h3 class="mb-0">{{ __('Edit Custom Page') }}</h3>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>{{ __('Page Title') }}</label>
						<input type="text" name="title" required="" value="{{ $info->title ?? '' }}" class="form-control">
					</div>
					<div class="form-group">
						<label>{{ __('Page Description') }}</label>
						<textarea name="description" required="" class="summernote form-control h-200">{{ $info->description->value ?? '' }}</textarea>
					</div>
					
					<div class="from-group row">
						<label  class="col-lg-12">{{ __('SEO Meta Title') }}</label>
						<div class="col-lg-12">
							<input type="text" name="meta_title" value="{{ $seo->title ?? '' }}" required="" class="form-control">
						</div>
					</div>     
					<div class="from-group row mt-2">
						<label  class="col-lg-12">{{ __('SEO Meta Description') }}</label>
						<div class="col-lg-12">
							<textarea name="meta_description" required="" class="form-control h-100">{{ $seo->description ?? '' }}</textarea>
						</div>
					</div>
					<div class="from-group row mt-2">
						<label  class="col-lg-12">{{ __('SEO Meta Tags') }}</label>
						<div class="col-lg-12">
							<input type="text" name="meta_tags" required="" class="form-control" value="{{ $seo->tags ?? '' }}">
						</div>
					</div>

					<div class="d-flex mt-2">
						<label class="custom-toggle custom-toggle-primary">
							<input type="checkbox"  name="status" value="1"  id="plain-text-with-button"  data-target=".plain-title-with-button" class="save-template" {{ $info->status == 1 ? 'checked' : '' }}>
							<span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
						</label>
						<label class="mt-1 ml-1" for="plain-text-with-button"><h4>{{ __('Make it publish?') }}</h4></label>
					</div>


					<div class="from-group row mt-3">
						<div class="col-lg-12">
							<button class="btn btn-neutral submit-button">{{ __('Update') }}</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		
	</div>
</form>
@endsection
@push('js')
<script  src="{{ asset('assets/plugins/summernote/summernote-bs4.js') }}"></script>
<script  src="{{ asset('assets/plugins/summernote/summernote.js') }}"></script>
@endpush