@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Menu List'),
'buttons'=>[
   [
      'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create Menu'),
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
									{{ $totalMenus }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-chart-tree mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Menus') }}</h5>
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
									{{ $totalActiveMenus }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-badge-check mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Active Menus') }}</h5>
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
									{{ $totalDraftMenus }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-box mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Draft Menu') }}</h5>
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
				<h3 class="mb-0">{{ __('Menu List') }}</h3>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th class="col-2">{{ __('Menu Name') }}</th>
							<th class="col-2">{{ __('Position') }}</th>
							<th class="col-2 text-center">{{ __('Language') }}</th>
							<th class="col-2">{{ __('Status') }}</th>
							<th class="col-2">{{ __('Last Update') }}</th>
							<th class="col-2 text-right">{{ __('Action') }}</th>
						</tr>
					</thead>					
						@foreach($menus as $menu)
						<tr>
							<td class="text-left">
								<a href="{{ route('admin.menu.show',$menu->id) }}">{{ $menu->name }}</a>
							</td>
							<td class="text-left">
								{{ $menu->position }}
							</td>
							<td class="text-center">
								{{ $menu->lang }}
							</td>
							<td class="text-left">
								<span class="badge badge-{{ $menu->status == 1 ? 'success' : 'danger' }}">
									{{ $menu->status == 1 ? __('Active') : __('Draft') }}
								</span>
							</td>
							<td>
								{{ $menu->updated_at->format('F-d-Y') }}
							</td>
							<td class="text-right">
								<a href="{{ route('admin.menu.show',$menu->id) }}" class="btn btn-neutral btn-sm" data-toggle="tooltip" data-placement="top" title="{{ __('Edit Menu') }}"><i class="fi fi-rs-diagram-project mt-3 pt-3"></i></a>

								<a href="{{ route('admin.menu.show',$menu->id) }}" 
									class="edit-contact btn btn-sm btn-primary" 	      
									data-toggle="tooltip" data-placement="top" title="{{ __('Customize Menu Items') }}"   	
									data-action="{{ route('admin.menu.update',$menu->id) }}" 
									data-name="{{ $menu->name }}"  
									data-position="{{ $menu->position }}"
									data-lang="{{ $menu->lang }}"
									data-status="{{ $menu->status }}"
									data-toggle="modal" 
									data-target="#editModal">
									<i class="fi fi-rs-edit"></i>
								</a>

								<a 
								class="delete-confirm btn btn-sm btn-danger" 
								href="javascript:void(0)" 
								data-action="{{ route('admin.menu.destroy',$menu->id) }}"
								data-toggle="tooltip" data-placement="top" title="{{ __('Delete Menu') }}"   	
								><i class="fas fa-trash"></i></a>

																
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>				
			</div>			
		</div>
	</div>
</div>


<div class="modal fade" id="addRecord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="{{ route('admin.menu.store') }}" class="ajaxform_instant_reload">
            @csrf
            <div class="modal-header">
               <h3>{{ __('Create Menu') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Menu Name') }}</label>
                  <input type="text" name="name" class="form-control" required="" placeholder="Example">
               </div>
               <div class="form-group">
                  <label>{{ __('Select Menu Position') }}</label>
                  <select class="form-control" name="position">
                  	<option value="main-menu">{{ __('Main Menu') }}</option>
                  	<option value="footer-left" class="none">{{ __('Footer Left') }}</option>
                  	<option value="footer-right" class="none">{{ __('Footer right') }}</option>
                  	<option value="footer-center" class="none">{{ __('Footer Center') }}</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>{{ __('Select Language') }}</label>
                  <select class="form-control" name="language">
                  	@foreach($languages as $languageKey => $language)
                  	<option value="{{ $languageKey }}">{{ $language }}</option>
                  	@endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label>{{ __('Menu Status') }}</label>
                  <select class="form-control" name="status">
                    <option value="1">{{ __('Active') }}</option>
                    <option value="0" selected="">{{ __('Draft') }}</option>
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


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form type="POST" action="" class="edit-modal ajaxform_instant_reload">
				@csrf
				@method('PUT')

				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Menu') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				 <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Menu Name') }}</label>
                  <input type="text" id="name" name="name" class="form-control" required="" placeholder="Example">
               </div>
               <div class="form-group">
                  <label>{{ __('Select Menu Position') }}</label>
                  <select class="form-control" name="position" id="position">
                  	<option value="main-menu">{{ __('Main Menu') }}</option>
                  	<option value="footer-left" class="none">{{ __('Footer Left') }}</option>
                  	<option value="footer-right" class="none">{{ __('Footer right') }}</option>
                  	<option value="footer-center" class="none">{{ __('Footer Center') }}</option>
                  </select>
               </div>
               <div class="form-group">
                  <label>{{ __('Select Language') }}</label>
                  <select class="form-control" name="language" id="language">
                  	@foreach($languages as $languageKey => $language)
                  	<option value="{{ $languageKey }}">{{ $language }}</option>
                  	@endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label>{{ __('Menu Status') }}</label>
                  <select class="form-control" name="status" id="status">
                    <option value="1">{{ __('Active') }}</option>
                    <option value="0">{{ __('Draft') }}</option>
                  </select>
               </div>
            </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
					<button type="submit" class="btn btn-primary submit-btn">{{ __('Save changes') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/js/pages/admin/menu-list.js') }}"></script>
@endpush