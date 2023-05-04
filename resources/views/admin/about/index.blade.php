@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['title'=> __('Edit About Page')])
@endsection
@section('content')
<div class="row">
	<div class="col-12 col-sm-12 col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('About Us') }}</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-3">
						<ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="true">{{ __('About Us Section') }}</a>
							</li>
							<li class="nav-item mt-2">
								<a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="false">{{ __('Counter Area Section') }}</a>
							</li>
							<li class="nav-item mt-2 none">
								<a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4" role="tab" aria-controls="contact" aria-selected="false"></a>
							</li>
						</ul>
					</div>
					<div class="col-12 col-sm-12 col-md-9">
						<div class="tab-content no-padding" id="myTab2Content">
							<div class="tab-pane fade show active" id="home4" role="tabpanel" aria-labelledby="home-tab4">
								<form method="post" action="{{ route('admin.about.store') }}" enctype="multipart/form-data" class="ajaxform">
									@csrf
									<input type="hidden" name="type" value="about">
									<input type="hidden" name="lang" value="en">
									<div class="form-group">
										<label>{{ __('Breadcrumb Title:') }}</label>
										<input type="text" name="breadcrumb_title" required="" class="form-control" value="{{ $about->breadcrumb_title ?? '' }}" placeholder="About Us">
									</div>
									<div class="form-group">
										<label>{{ __('Section Title:') }}</label>
										<input type="text" name="section_title" required="" class="form-control" value="{{ $about->section_title ?? '' }}" placeholder="Over 12 years of experience in the IT Industry & Tech service">
									</div>
									<div class="form-group">
										<label>{{ __('About Image 1:') }}</label>
										<input type="file" name="about_image_1" accept="image/*"  class="form-control" >
									</div>
									<div class="form-group">
										<label>{{ __('About Image 2:') }}</label>
										<input type="file" name="about_image_2" accept="image/*"  class="form-control" >
									</div>
									<div class="form-group">
										<label>{{ __('Experience:') }}</label>
										<input type="number" name="experience"  class="form-control" value="{{ $about->experience ?? '' }}" placeholder="12">
									</div>
									<div class="form-group">
										<label>{{ __('Experience Title:') }}</label>
										<input type="text" name="experience_title" required="" class="form-control" value="{{ $about->experience_title ?? '' }}" placeholder="Years of Experience">
									</div>
									<div class="form-group">
										<label>{{ __('About Description:') }}</label>
										<textarea class="form-control" required="" name="description">{{ $about->description ?? '' }}</textarea>
									</div>
									<div class="form-group">
										<label>{{ __('Section Button Name:') }}</label>
										<input type="text" name="button_title"  class="form-control" value="{{ $about->button_title ?? ''  }}" placeholder="Check our work">
									</div>
									<div class="form-group">
										<label>{{ __('Section Button Link:') }}</label>
										<input type="text" name="button_link"  class="form-control" value="{{ $about->button_link ?? '' }}" placeholder="">
									</div>
									<div class="form-group">
										<label>{{ __('Introducing video link (youtube)') }}</label>
										<input type="text" name="introducing_video"  class="form-control" value="{{ $about->introducing_video ?? '' }}" placeholder="https://www.youtube.com/watch?v=Fu3MIwF-LJw">
									</div>
									<div class="form-group">
										<label>{{ __('Facilities:') }}</label>
										<textarea class="form-control" name="facilities" placeholder="example1, example2">{{ $about->facilities ?? '' }}</textarea>
										<small>{{ __('use comma (,) for line break') }}</small>
									</div>
									<div class="form-group">
										<button class="btn btn-neutral submit-button" type="submit">{{ __('Update') }}</button>
									</div>
								</form>
							</div>
							<div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
								<form method="post" action="{{ route('admin.about.store') }}" class="ajaxform">
									@csrf
									<input type="hidden" name="type" value="counter">
									<input type="hidden" name="lang" value="en">

									<div class="form-group">
										<label>{{ __('Years of Experience') }}</label>
										<input type="text" name="counter[experience]"  class="form-control" value="{{ $counter_section->experience ?? '' }}" placeholder="12+" required="">
									</div>
									<div class="form-group">
										<label>{{ __('Active Customers') }}</label>
										<input type="text" name="counter[active_customers]"  class="form-control" value="{{ $counter_section->active_customers ?? '' }}" placeholder="900+" required="">
									</div>
									<div class="form-group">
										<label>{{ __('Positive Reviews') }}</label>
										<input type="text" name="counter[positive_reviews]"  class="form-control" value="{{ $counter_section->positive_reviews ?? '' }}" placeholder="200+" required="">
									</div>
									<div class="form-group">
										<label>{{ __('Satisfied clients') }}</label>
										<input type="text" name="counter[satisfied_customers]"  class="form-control" value="{{ $counter_section->satisfied_customers ?? '' }}" placeholder="600+" required="">
									</div>
									<div class="form-group">
										<button class="btn btn-neutral submit-button" type="submit">{{ __('Update') }}</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection