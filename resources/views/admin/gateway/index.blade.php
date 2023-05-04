@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Payment Gateways'),
'buttons'=>[
	[
		'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create A Manual Gateway'),
		'url'=>route('admin.gateways.create'),
	]
]])
@endsection
@section('content')
<div class="row d-flex justify-content-between flex-wrap">
	<div class="col">
		<div class="card card-stats">
			<div class="card-body">
				<div class="row">
					<div class="col">
						<span class="h2 font-weight-bold mb-0 total-transfers" id="total-device">
							{{ $totalGateways }}
						</span>
					</div>
					<div class="col-auto">
						<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
							<i class="fi fi-rs-bank mt-2"></i>
						</div>
					</div>
				</div>
				<p class="mt-3 mb-0 text-sm">
				</p><h5 class="card-title  text-muted mb-0">{{ __('Total Gateways') }}</h5>
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
							{{ $active_gateway }}
						</span>
					</div>
					<div class="col-auto">
						<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
							<i class="fi  fi-rs-badge-check mt-2"></i>
						</div>
					</div>
				</div>
				<p class="mt-3 mb-0 text-sm">
				</p><h5 class="card-title  text-muted mb-0">{{ __('Active Gateways') }}</h5>
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
							{{ $inactive_gateway }}
						</span>
					</div>
					<div class="col-auto">
						<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
							<i class="fi fi-rs-delete-document mt-2"></i>
						</div>
					</div>
				</div>
				<p class="mt-3 mb-0 text-sm">
				</p><h5 class="card-title  text-muted mb-0">{{ __('Inactive Gateways') }}</h5>
				<p></p>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col">
		<div class="card">
			<!-- Card header -->
			<div class="card-header border-0">
				<h3 class="mb-0">{{ __('Gateways') }}</h3>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th scope="col" class="sort col-3" >{{ __('Name') }}</th>
							<th scope="col" class="sort col-1 text-right">{{ __('Minimum Amount') }}</th>
							<th scope="col" class="sort col-1 text-right">{{ __('Maximum Amount') }}</th>
							<th scope="col" class="sort col-1 text-right">{{ __('Charge') }}</th>
							<th scope="col" class="sort col-1 text-right">{{ __('Currency') }}</th>
							<th scope="col" class="sort col-1 text-right">{{ __('Gateway Status') }}</th>
							<th scope="col" class="sort col-2 text-right">{{ __('Payment Mode') }}</th>
							<th scope="col" class="sort col-2 text-right">{{ __('Edit') }}</th>
						</tr>
					</thead>
					<tbody class="list">
						@foreach($gateways as $gateway)
						<tr>
							<th scope="row">
								<div class="media align-items-center">
									@if($gateway->logo != null)
									<a href="{{ route('admin.gateways.edit',$gateway->id) }}" class="avatar rounded-square mr-3">
										<img alt="Image placeholder" src="{{ asset($gateway->logo) }}">
									</a>
									@endif
									<div class="media-body">
										<span class="name mb-0 text-sm">{{ $gateway->name }}</span>
									</div>
								</div>
							</th>
							<td class="text-center">{{ number_format($gateway->min_amount,2) }}</td>
							<td class="text-center">{{ number_format($gateway->max_amount,2) }}</td>
							<td class="text-right">{{ $gateway->charge.strtoupper($gateway->currency) }}</td>
							<td class="text-right">{{ strtoupper($gateway->currency) }}</td>
							<td class="text-center">
								<span class="badge badge-dot text-right">
									<i class="bg-{{ $gateway->status == 1 ? 'success' : 'danger' }}"></i>
									<span class="status">{{ $gateway->status == 1 ? 'Active' : 'Disabled' }}</span>
								</span>
							</td>
							
							<td class="text-right">
								<span class="badge badge-dot ">
									<i class="bg-{{ $gateway->test_mode == 1 ? 'danger' : 'success' }}"></i>
									<span class="status">{{ $gateway->test_mode == 1 ? 'Sandbox' : 'Live' }}</span>
								</span>
							</td>
							<td class="text-right">
								<a class="btn btn-sm btn-neutral" href="{{ route('admin.gateways.edit',$gateway->id) }}">
									<i class="fas fa-edit"></i>
								</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection