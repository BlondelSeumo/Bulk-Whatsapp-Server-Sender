@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['title'=> __('Customers')])
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
									{{ $totalCustomers }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-users-alt mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Customers') }}</h5>
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
									{{ $totalActiveCustomers }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-map-marker-check mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Active Customers') }}</h5>
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
									{{ $totalExpiredCustomers }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-user-time mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Expired Customers') }}</h5>
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
									{{ $totalSuspendedCustomers }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-delete-user mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Suspended Customers') }}</h5>
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
				<h3 class="mb-0">{{ __('Customers') }}</h3>
				<form action="" class="card-header-form">
					<div class="input-group">
						<input type="text" name="search" value="{{ $request->search ?? '' }}" class="form-control" placeholder="Search......">
						<select class="form-control" name="type">
							<option value="email" @if($type == 'email') selected="" @endif>{{ __('User Email') }}</option>
							<option value="name" @if($type == 'name') selected="" @endif>{{ __('Name') }}</option>
							
						</select>
						<div class="input-group-btn">
							<button class="btn btn-neutral btn-icon"><i class="fas fa-search"></i></button>
						</div>
					</div>
				</form>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th class="col-1">{{ __('Name') }}</th>
							<th class="col-4">{{ __('Email') }}</th>
							<th class="col-2">{{ __('Plan') }}</th>
							<th class="col-1">{{ __('Orders') }}</th>
							<th class="col-1">{{ __('Expire Date') }}</th>
							<th class="col-1">{{ __('Status') }}</th>
							<th class="col-1 text-left">{{ __('Created At') }}</th>
							<th class="col-1 text-left">{{ __('Action') }}</th>
						</tr>
					</thead>
					@if(count($customers) != 0)
					<tbody class="list">
						@foreach($customers ?? [] as $customer)
						<tr>
							<td class="text-left">
								<a href="{{ route('admin.customer.show',$customer->id) }}" class="text-dark">
									{{ $customer->name }}
								</a>
							</td>
							<td>
								<a class="text-dark" href="{{ route('admin.customer.edit',$customer->id) }}">
									{{ Str::limit($customer->email ?? '',50) }}
								</a>
							</td>
							<td>
	       						{{ $customer->subscription->title ?? '' }}
							</td>

							<td class="text-center">
								{{ number_format($customer->orders_count) }}
							</td>
							<td class="text-center">
								{{ $customer->will_expire }}
							</td>
							<td>
								<span class="badge badge-{{ $customer->status == 1 ? 'success' : 'danger' }}">
									{{ $customer->status == 1 ? 'Active' : 'Suspended' }}
								</span>
							</td>
							
							<td class="text-center">
								{{ $customer->created_at->format('d F y') }}
							</td>
							<td>
								
								<div class="dropdown">
									<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a class="dropdown-item" href="{{ route('admin.customer.show',$customer->id) }}">{{ __('View') }}</a>
										<a class="dropdown-item" href="{{ route('admin.customer.edit',$customer->id) }}">{{ __('Edit') }}</a>
										<a class="dropdown-item delete-confirm" href="#" data-action="{{ route('admin.customer.destroy',$customer->id) }}">{{ __('Remove') }}</a>
										
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
					@endif
				</table>
				@if(count($customers) == 0)
				<div class="text-center mt-2">
					<div class="alert  bg-gradient-primary text-white">
						<span class="text-left">{{ __('!Opps no records found') }}</span>
					</div>
				</div>
				@endif
			</div>
			<div class="card-footer py-4">
				{{ $customers->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
			</div>	
		</div>
	</div>
</div>
@endsection