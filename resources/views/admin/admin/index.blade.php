@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Admins'),
'buttons'=>[
   [
      'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create a admin'),
      'url'=>route('admin.admin.create')
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
						<h4>{{ __('Admins') }}</h4>
					</div>
					<div class="col-lg-6">
					</div>
				</div>
				<br>
				<div class="card-action-filter">
					<div class="table-responsive custom-table">
						<table class="table">
							<thead>
								<tr>									
									<th>{{ __('Name') }}</th>
									<th>{{ __('Email') }}</th>
									<th>{{ __('Status') }}</th>
									<th>{{ __('Role') }}</th>
									<th class="text-right">{{ __('Action') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($users as $row)
								<tr>
									<td>
										{{ $row->name }}										
									</td>
									<td>
										{{ $row->email }}
									</td>
									<td>@if($row->status==1)
										<span class="badge badge-success">{{ __('Active') }}</span>
										@else
										<span class="badge badge-danger">{{ __('Deactive') }}</span>

									@endif</td>
									<td>@foreach($row->roles as $r) <span class="badge badge-primary">{{ $r->name }}</span> @endforeach</td>
									<td class="text-right">
										<a href="{{ route('admin.admin.edit',$row->id) }}" class="btn btn-neutral btn-sm">{{ __('Edit') }}</a>
										<a href="#" data-action="{{ route('admin.admin.destroy',$row->id) }}" class="btn btn-neutral btn-sm delete-confirm">{{ __('Delete') }}</a>
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