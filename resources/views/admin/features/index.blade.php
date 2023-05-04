@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Features'),
'buttons'=>[
   [
      'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create feature'),
      'url'=>route('admin.features.create'),
      
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
				<h3 class="mb-0">{{ __('Our Features') }}</h3>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th class="col-3">{{ __('Title') }}</th>
							<th class="col-6">{{ __('Description') }}</th>
							<th class="col-1 text-right">{{ __('Language') }}</th>
							<th class="col-1 text-right">{{ __('Action') }}</th>
						</tr>
					</thead>					
						@foreach($posts ?? [] as  $post)
						<tr>
							<td class="text-left">
								<img src="{{ asset($post->preview->value) }}" class="avatar rounded-circle mr-3">
								{{ Str::limit($post->title,30) }}
							</td>
							<td class="text-left">
								{{ Str::limit($post->excerpt->value ?? '',50) }}
							</td>
							<td class="text-right">
								{{ $post->lang }}
							</td>
							<td class="text-right">
								<div class="btn-group mb-2 float-right">
									<button class="btn btn-neutral btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										{{ __('Action') }}
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item has-icon" href="{{ route('admin.features.edit',$post->id) }}" >
										<i class="fi fi-rs-edit"></i>{{ __('Edit') }}</a>

										
										<a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-action="{{ route('admin.features.destroy',$post->id) }}"><i class="fas fa-trash"></i>{{ __('Remove') }}</a>
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
         <form method="POST" action="{{ route('admin.features.store') }}" class="ajaxform_instant_reload" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
               <h3>{{ __('Create Feature') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('title') }}</label>
                  <input type="text" name="title" maxlength="150" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>{{ __('preview image') }}</label>
                  <input type="file" name="preview_image" accept="image/*" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>{{ __('description') }}</label>
                 <textarea class="form-control h-100" maxlength="500" name="description" required=""></textarea>
               </div>
               <div class="form-group">
                  <label>{{ __('Select Language') }}</label>
                 <select class="form-control" name="language" required="">
                 	@foreach($languages as $languageKey => $language)
                 	<option value="{{ $languageKey }}">{{ $language }}</option>
                 	@endforeach
                 </select>
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
               <h3>{{ __('Edit Feature') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('title') }}</label>
                  <input type="text" name="title" maxlength="150" class="form-control" id="title" required="">
               </div>
               <div class="form-group">
                  <label>{{ __('description') }}</label>
                 <textarea class="form-control h-100" maxlength="500" name="description" required="" id="description"></textarea>
               </div>
               <div class="form-group">
                  <label>{{ __('preview image') }}</label>
                  <input type="file" name="preview_image" accept="image/*" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>{{ __('Select Language') }}</label>
                 <select class="form-control" name="language" id="language" required="">
                 	@foreach($languages as $languageKey => $language)
                 	<option value="{{ $languageKey }}">{{ $language }}</option>
                 	@endforeach
                 </select>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-outline-primary col-12 submit-button" >{{ __('Update') }}</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/js/pages/admin/features.js') }}"></script>
@endpush