@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Customers'),
'buttons'=>[
	[
		'name'=>__('Back'),
		'url'=>route('admin.customer.index'),
	]
]])
@endsection
@section('content')
<div class="row">
	<div class="col-sm-4">
		<div class="card card-profile">
			<div class="card-img-top bg-gradient-info h-150" >

			</div>
			<div class="row justify-content-center">
				<div class="col-lg-3 order-lg-2">
					<div class="card-profile-image">
						<a href="#">
							<img src="{{ $customer->avatar == null ? 'https://ui-avatars.com/api/?name='.$customer->name : asset($customer->avatar)  }}" class="rounded-circle">
						</a>
					</div>
				</div>
			</div>

			<div class="card-body pt-2">
				<div class="row">
					<div class="col">
						<div class="card-profile-stats d-flex justify-content-center">
							<div>
								<span class="heading">{{ $customer->orders_count }}</span>
								<span class="description">{{ __('Orders') }}</span>
							</div>
							<div>
								<span class="heading">{{ $customer->smstransaction_count }}</span>
								<span class="description">{{ __('Transactions') }}</span>
							</div>
							<div>
								<span class="badge badge-{{ $customer->status == 1 ? 'success' : 'danger' }} badge-sm"><small>{{ $customer->status == 1 ? 'Active' : 'Suspended' }}</small></span>
								<span class="description">{{ __('Status') }}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="text-center">
					<h5 class="h3">
						{{ $customer->name }}
					</h5>
					<div class="h5 font-weight-300">
						<i class="ni location_pin mr-2"></i>{{ __('Join Date: ') }} {{ $customer->created_at->format('d F Y') }}<br>
						<i class="ni location_pin mr-2"></i>{{ __('Will Expire: ') }} {{ $customer->will_expire }}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-8">	
		<div class="card">
			<div class="card-body">
				<div class="timeline timeline-one-side" data-timeline-content="axis" data-timeline-axis-style="dashed">
					<div class="timeline-block">
						<span class="timeline-step badge-success">
							<i class="ni ni-circle-08"></i>
						</span>
						<div class="timeline-content">
							<small class="text-muted font-weight-bold">{{ __('Bio') }}</small>
							<p>{{ __('Name : ') }} {{ $customer->name }}</p>
							<p>{{ __('Email : ') }} {{ $customer->email }}</p>
							<p>{{ __('Phone : ') }} {{ $customer->phone }}</p>
							<p>{{ __('Address : ') }} {{ $customer->address }}</p>
							
						</div>
					</div>
					<div class="timeline-block">
						<span class="timeline-step badge-danger">
							<i class="ni ni-chart-pie-35"></i>
						</span>
						<div class="timeline-content">
							<small class="text-muted font-weight-bold">{{ __('Other Info') }}</small>
							<p>{{ __('Plan Name:') }} <strong>{{ $customer->subscription->title ?? '' }}</strong></p>
							<p>{{ __('Plan Expire Date:') }} {{ $customer->will_expire ?? '' }}</p>
							<p>{{ __('Total Spended:') }} {{ $customer->orders_sum_amount != null ? amount_format($customer->orders_sum_amount ?? '') : 0 }}</p>
							<p>{{ __('Total Devices:') }} {{ $customer->device_count ?? '' }}</p>
							<p>{{ __('Total Messages:') }} {{ $customer->smstransaction_count ?? '' }}</p>
							<p>{{ __('Total Contacts:') }} {{ $customer->contact_count ?? '' }}</p>	
						</div>
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
				<h3 class="mb-0">{{ __('Orders') }}</h3>
				
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th class="col-1">{{ __('Order No') }}</th>
							<th class="col-4">{{ __('Plan Name') }}</th>
							<th class="col-2">{{ __('Payment Mode') }}</th>
							<th class="col-1">{{ __('Amount') }}</th>
							<th class="col-1">{{ __('Status') }}</th>
							
							<th class="col-2 text-left">{{ __('Created At') }}</th>
							<th class="col-1 text-left">{{ __('View') }}</th>
						</tr>
					</thead>
					@if(count($orders) != 0)
					<tbody class="list">
						@foreach($orders ?? [] as $order)
						<tr>
							<td class="text-center">
								<a href="{{ route('admin.order.show',$order->id) }}" class="text-dark">
									{{ $order->invoice_no }}
								</a>
							</td>
							<td>
								<a class="text-dark" href="{{ route('admin.plan.edit',$order->plan_id) }}">
									{{ Str::limit($order->plan->title ?? '',50) }}
								</a>
							</td>
							<td>
	       						{{ $order->gateway->name ?? '' }}
							</td>

							<td class="text-center">
								{{ number_format($order->amount,2) }}
							</td>
							<td>
								<span class="badge badge-{{ $order->status == 2 ? 'warning' : ($order->status == 1 ? 'success' : 'danger') }}">
									{{ $order->status == 2 ? 'pending' : ($order->status == 1 ? 'approved' : 'declined') }}
								</span>
							</td>
							
							<td class="text-center">
								{{ $order->created_at->format('d F y') }}
							</td>
							<td>
								<a href="{{ route('admin.order.show',$order->id) }}" class="btn btn-neutral btn-sm">{{ __('View') }}</a>
							</td>
						</tr>
						@endforeach
					</tbody>
					@endif
				</table>
				@if(count($orders) == 0)
				<div class="text-center mt-2">
					<div class="alert  bg-gradient-primary text-white">
						<span class="text-left">{{ __('!Opps no orders found') }}</span>
					</div>
				</div>
				@endif
			</div>
			<div class="card-footer py-4">
				{{ $orders->links('vendor.pagination.bootstrap-4') }}
			</div>	
		</div>
	</div>
</div>

@endsection