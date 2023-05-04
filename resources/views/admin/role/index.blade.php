@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Admin Roles'),
'buttons'=>[
	[
		'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create a Role'),
		'url'=>route('admin.role.create')
	]
]

])
@endsection
@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card"  >
			<div class="card-body">
				<div class="row mb-30">
					<div class="col-lg-6">
						<h4>{{ __('Roles') }}</h4>
					</div>
					<div class="col-lg-6">				
					</div>
				</div>
				<br>
				<div class="table-responsive custom-table">
					<table class="table">
						<thead>
							<tr>
								<th width="10%">{{ __('Name') }}</th>
								<th width="80%">{{ __('Permissions') }}</th>
								<th width="10%" class="text-right">{{ __('Action') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach($roles as $role)
							<tr>							
								<td>
									{{ $role->name }}
								</td>
								<td>
									@foreach ($role->permissions as $perm)
									<span class="badge badge-primary mr-1 mb-2">
										{{ $perm->name }}
									</span>
									@endforeach
								</td>
								<td>
									<div class="hover">
										<a href="javascript:void(0)"  data-action="{{ route('admin.role.destroy',$role->id) }}" class="btn btn-neutral con btn-sm  delete-confirm">{{ __('Delete') }}</a>
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>				
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection