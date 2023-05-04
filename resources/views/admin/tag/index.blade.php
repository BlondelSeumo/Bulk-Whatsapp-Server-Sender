@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Categories'),
'buttons'=>[
   [
      'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create a Tag'),
      'url'=>'#',
      'components'=>'data-toggle="modal" data-target="#addRecord" id="add_record"',
      'is_button'=>true
   ]
]
])
@endsection
@section('content')
<div class="row justify-content-center">
	<div class="col-12">
		<div class="row d-flex justify-content-between flex-wrap">
			<div class="col">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<span class="h2 font-weight-bold mb-0 total-transfers" id="total-device">
									{{ $totalTags }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-tags mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Tags') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<span class="h2 font-weight-bold mb-0 total-transfers" id="total-active">
									{{ $activeTags }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-badge-check mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Active Tags') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<span class="h2 font-weight-bold mb-0 completed-transfers" id="total-inactive">
									{{ $inActiveTags }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-ticket-alt mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Inactive Tags') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>  


<div class="row">
	<div class="col">
		<div class="card">
			<!-- Card header -->
			<div class="card-header border-0">
				<h3 class="mb-0">{{ __('Tags') }}</h3>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th class="col-2">{{ __('Name') }}</th>
							<th class="col-2">{{ __('Slug') }}</th>
							<th class="col-2 text-center">{{ __('Uses for blog') }}</th>
							<th class="col-2">{{ __('Status') }}</th>
							<th class="col-2">{{ __('Created At') }}</th>
							<th class="col-2 text-right">{{ __('Action') }}</th>
						</tr>
					</thead>					
						@foreach($tags as $tag)
						<tr>
							<td class="text-left">
								{{ $tag->title }}
							</td>
							<td class="text-left">
								{{ $tag->slug }}
							</td>
							<td class="text-center">
								{{ $tag->postcategories_count }}
							</td>
							<td class="text-left">
								<span class="badge badge-{{ $tag->status == 1 ? 'success' : 'danger' }}">
									{{ $tag->status == 1 ? __('Active') : __('Draft') }}
								</span>
							</td>
							<td>
								{{ $tag->created_at->format('F-d-Y') }}
							</td>
							<td class="text-right">
								<div class="btn-group mb-2 float-right">
									<button class="btn btn-neutral btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										{{ __('Action') }}
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item has-icon edit-row" href="#" 
										data-action="{{ route('admin.tag.update',$tag->id) }}" 
										data-title="{{ $tag->title }}"  
										data-slug="{{ $tag->slug }}"  
										data-lang="{{ $tag->lang }}"
										data-status="{{ $tag->status }}"
										data-toggle="modal" 
										data-target="#editModal"
										>
										<i class="fi fi-rs-edit"></i>{{ __('Edit') }}</a>

										
										<a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-action="{{ route('admin.tag.destroy',$tag->id) }}"><i class="fas fa-trash"></i>{{ __('Remove Tag') }}</a>
									</div>
								</div>								
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@if(count($tags) == 0)
				<div class="text-center mt-2">
					<div class="alert  bg-gradient-primary text-white">
						<span class="text-left">{{ __('!Opps no records found') }}</span>
					</div>
				</div>
				@endif				
			</div>			
		</div>
	</div>
</div>


<div class="modal fade" id="addRecord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="{{ route('admin.tag.store') }}" class="ajaxform_instant_reload">
            @csrf
            <div class="modal-header">
               <h3>{{ __('Create Tag') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Title') }}</label>
                  <input type="text" name="title" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>{{ __('Status') }}</label>
                  <select class="form-control" name="status">
                  	<option value="1">{{ __('Active') }}</option>
                  	<option value="0">{{ __('InActive') }}</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>{{ __('Status') }}</label>
                  <select class="form-control" name="language">
                  	@foreach($languages as $languageKey => $language)
                  	<option value="{{ $languageKey }}">{{ $language }}</option>
                  	@endforeach
                  </select>
               </div>
               
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-outline-primary col-12 submit-button" >{{ __('Create Now') }}</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="" class="ajaxform_instant_reload edit-form">
            @csrf
            @method('PUT')
            <div class="modal-header">
               <h3>{{ __('Edit Tag') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Title') }}</label>
                  <input type="text" name="title" id="title" class="form-control" required="">
               </div>
              
               <div class="form-group">
                  <label>{{ __('Status') }}</label>
                  <select class="form-control" name="status" id="status">
                  	<option value="1">{{ __('Active') }}</option>
                  	<option value="0">{{ __('InActive') }}</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>{{ __('Status') }}</label>
                  <select class="form-control" name="language" id="language">
                  	@foreach($languages as $languageKey => $language)
                  	<option value="{{ $languageKey }}">{{ $language }}</option>
                  	@endforeach
                  </select>
               </div>
               
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-outline-primary col-12 submit-button" >{{ __('Update Now') }}</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/js/pages/admin/tag.js') }}"></script>
@endpush