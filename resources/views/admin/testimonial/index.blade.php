@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Features'),
'buttons'=>[
   [
      'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create Testimonial'),
      'url'=>'#',
      'components'=>'data-toggle="modal" data-target="#addRecord" id="add_record"',
      'is_button'=>true
   ]
]

])
@endsection
@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<!-- Card header -->
			<div class="card-header border-0">
				<h3 class="mb-0">{{ __('Testimonials') }}</h3>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th class="col-3">{{ __('Reviewer Name') }}</th>
							<th class="col-2">{{ __('Reviewer Position') }}</th>
							<th class="col-4">{{ __('Comment') }}</th>
							<th class="col-1 text-right">{{ __('Ratings') }}</th>
							<th class="col-1 text-right">{{ __('Action') }}</th>
						</tr>
					</thead>					
						@foreach($posts ?? [] as  $post)
						<tr>
							<td class="text-left">
								<img src="{{ asset($post->preview->value) }}" class="avatar rounded-square mr-3">
								{{ Str::limit($post->title,30) }}
							</td>
							<td class="text-left">
								{{ Str::limit($post->slug,30) }}
							</td>
							<td class="text-left">
								{{ Str::limit($post->excerpt->value ?? '',50) }}
							</td>
							<td class="text-right">
								{{ $post->lang }} {{ __('Star') }}
							</td>
							<td class="text-right">
								<div class="btn-group mb-2 float-right">
									<button class="btn btn-neutral btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										{{ __('Action') }}
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item has-icon edit-row" href="#" 
										data-action="{{ route('admin.testimonials.update',$post->id) }}" 
										data-title="{{ $post->title ?? '' }}"
										data-slug="{{ $post->slug ?? '' }}"
										data-comment="{{ $post->excerpt->value ?? '' }}"  
										data-lang="{{ $post->lang }}"
										data-toggle="modal" 
										data-target="#editModal"
										>
										<i class="fi fi-rs-edit"></i>{{ __('Edit') }}</a>

										
										<a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-action="{{ route('admin.testimonials.destroy',$post->id) }}"><i class="fas fa-trash"></i>{{ __('Remove') }}</a>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>				
			</div>

			<div class="card-footer py-4">
				{{ $posts->links('vendor.pagination.bootstrap-5') }}
			</div>					
		</div>
	</div>
</div>




<div class="modal fade" id="addRecord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="{{ route('admin.testimonials.store') }}" class="ajaxform_instant_reload" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
               <h3>{{ __('Create Testimonial') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Reviewer Name') }}</label>
                  <input type="text" name="reviewer_name" maxlength="150" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>{{ __('Reviewer Position') }}</label>
                  <input type="text" name="reviewer_position" class="form-control" required="" placeholder="CEO of Google" maxlength="50">
               </div>
               <div class="form-group">
                  <label>{{ __('Reviewer Avatar') }}</label>
                  <input type="file" name="reviewer_avatar" accept="image/*" class="form-control" required="">
               </div>
                <div class="form-group">
                  <label>{{ __('Review Star') }}</label>
                  <select class="form-control" name="star">
                  	<option value="5">{{ __('5 Star') }}</option>
                  	<option value="4">{{ __('4 Star') }}</option>
                  	<option value="3">{{ __('3 Star') }}</option>
                  	<option value="2">{{ __('2 Star') }}</option>
                  	<option value="1">{{ __('1 Star') }}</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>{{ __('Comment') }}</label>
                 <textarea class="form-control h-100" maxlength="500" name="comment" required=""></textarea>
               </div>
               
               <div class="form-group">
               	<button type="submit" class="btn btn-neutral  submit-button" >{{ __('Create Now') }}</button>
               </div>
            </div>
           
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="" class="ajaxform_instant_reload edit-modal" enctype="multipart/form-data">
            @csrf
            @method("PUT")

            <div class="modal-header">
               <h3>{{ __('Edit Testimonial') }}</h3>
            </div>
           <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Reviewer Name') }}</label>
                  <input type="text" name="reviewer_name" id="reviewer_name" maxlength="150" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>{{ __('Reviewer Position') }}</label>
                  <input type="text" name="reviewer_position" id="reviewer_position" class="form-control" required="" placeholder="CEO of Google" maxlength="50">
               </div>
               <div class="form-group">
                  <label>{{ __('Reviewer Avatar') }}</label>
                  <input type="file" name="reviewer_avatar" accept="image/*" class="form-control" >
               </div>
                <div class="form-group">
                  <label>{{ __('Review Star') }}</label>
                  <select class="form-control" name="star" id="star">
                  	<option value="5">{{ __('5 Star') }}</option>
                  	<option value="4">{{ __('4 Star') }}</option>
                  	<option value="3">{{ __('3 Star') }}</option>
                  	<option value="2">{{ __('2 Star') }}</option>
                  	<option value="1">{{ __('1 Star') }}</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>{{ __('Comment') }}</label>
                 <textarea class="form-control h-100" maxlength="500" name="comment" id="comment" required=""></textarea>
               </div>
               
               <div class="form-group">
               	<button type="submit" class="btn btn-neutral  submit-button" >{{ __('Update') }}</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/js/pages/admin/testimonial.js') }}"></script>
@endpush