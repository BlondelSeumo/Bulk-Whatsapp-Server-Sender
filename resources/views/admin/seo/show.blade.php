@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Edit SEO Settings'),
'buttons'=>[
	[
		'name'=>__('Back'),
		'url'=>route('admin.seo.index'),
	]
 ]
])
@endsection
@section('content')
<form class="ajaxform" method="post" action="{{ route('admin.seo.update',$id) }}" enctype="multipart/form-data">
	@csrf
	@method('PUT')
	
	<div class="row">
		<div class="col-lg-5">
			<strong>{{ __('Edit page seo settings') }}</strong>
			<p>{{ __('Edit page seo and necessary information from here') }}</p>
		</div>
		<div class="col-lg-7 card-wrapper">
			<!-- Alerts -->
			<div class="card">
				<div class="card-header">
					<h3 class="mb-0">{{ __('Edit Settings') }}</h3>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>{{ __('Meta Title') }}</label>
						<input type="text" name="metadata[site_name]" required="" value="{{ $contents->site_name ?? '' }}" class="form-control">
					</div>
					<div class="form-group">
						<label>{{ __('Meta Description') }}</label>
						<textarea name="metadata[matadescription]" required="" class="summernote form-control h-200">{{ $contents->matadescription ?? '' }}</textarea>
					</div>
					<div class="form-group">
						<label>{{ __('Meta Tags') }}</label>
						<input type="text" name="metadata[matatag]" required="" value="{{ $contents->matatag ?? '' }}" class="form-control">
					</div>
					@if(isset($contents->twitter_site_title))
					<div class="form-group">
						<label>{{ __('Twitter Site Title') }}</label>
						<input type="text" name="metadata[twitter_site_title]" required="" value="{{ $contents->twitter_site_title ?? '' }}" class="form-control">
					</div>
					@endif
					<div class="form-group">
						<label>{{ __('Meta Image') }}</label>
						<input type="file" accept="image/*" name="image"  class="form-control">
					</div>
					<div class="from-group row mt-3">
						<div class="col-lg-12">
							<button class="btn btn-neutral submit-button">{{ __('Save Changes') }}</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		
	</div>
</form>
@endsection