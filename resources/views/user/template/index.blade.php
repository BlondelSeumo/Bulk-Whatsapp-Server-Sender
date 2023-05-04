@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['title'=> 'All Templates','buttons'=>[
	[
		'name'=>'<i class="fas fa-plus"></i> &nbspCreate Template',
		'url'=> route('user.template.create'),
	]
]])
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
								   {{ $limit }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-layers mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Templates') }}</h5>
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
									{{ $active_templates }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-template mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Active Templates') }}</h5>
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
								  {{ $inactive_templates }}
							    </span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-template-alt mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Inactive Templates') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
		</div>

		@if(count($templates ?? []) == 0)
		<div class="row">
			<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<center>
						<img src="{{ asset('assets/img/404.jpg') }}" height="500">
						<h3 class="text-center">{{ __('!Opps You Have Not Created Any Template') }}</h3>
						<a href="{{ route('user.template.create') }}" class="btn btn-neutral"><i class="fas fa-plus"></i> {{ __('Create a template') }}</a>
					</center>
				</div>
			</div>
		</div>
		</div>

		@else
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<table class="table col-12">
							<thead>
								<tr>
									<th class="col-3">{{ __('Template Name') }}</th>
									<th class="col-2">{{ __('Type') }}</th>
									<th class="col-1">{{ __('Status') }}</th>
									<th class="col-2 text-right">{{ __('Action') }}</th>
								</tr>
							</thead>
							<tbody class="tbody">
								@foreach($templates ?? [] as $template)
									<tr>
										<td>
											{{ $template->title }}
										</td>
										<td>{{ $template->type }}</td>
										<td><span class="badge {{ badge($template->status)['class'] }}">{{ $template->status == 1 ? 'active' : 'inactive'  }}</span> </td>
										<td>
											<div class="btn-group mb-2 float-right">
												<button class="btn btn-neutral btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													{{ __('Action') }}
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item has-icon" href="{{ route('user.template.edit',$template->id) }}"><i class="fas fa-pen"></i>{{ __('Edit Template') }}</a>

													<a class="dropdown-item has-icon show-id" 
													href="javascript:void(0)" 
													data-toggle="modal" 
													data-uuid="{{ $template->uuid }}"
													data-templatename="{{ $template->title }}"
													data-target="#exampleModal"><i class="fas fa-id-card"></i>{{ __('View Template ID') }}</a>

													<a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-action="{{ route('user.template.destroy',$template->id) }}"><i class="fas fa-trash"></i>{{ __('Remove Template') }}</a>
													

												</div>
											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<div class="d-flex justify-content-center">{{ $templates->links('vendor.pagination.bootstrap-4') }}</div>
					</div>
				</div>
			</div>
		</div>
		
		@endif
	</div>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="templateName"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
        	<label>{{ __('Template ID') }}</label>
        	<input type="text" class="form-control" value="" id="templateid" disabled="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/js/pages/user/template-index.js') }}"></script>
@endpush