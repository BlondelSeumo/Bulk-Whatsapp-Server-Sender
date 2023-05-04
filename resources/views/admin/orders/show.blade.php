@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Dashboard'),
'buttons'=>[
	[
		'name'=> __('Orders'),
		'url'=>route('admin.order.index'),
	]
]
])
@endsection
@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<div class="invoice">
					<div class="invoice-print">
						<div class="row">
							<div class="col-lg-12">
								<div class="invoice-title">
									<span class="badge badge-{{ $order->status == 2 ? 'warning' : ($order->status == 1 ? 'success' : 'danger') }} float-right">
										{{ $order->status == 2 ? 'pending' : ($order->status == 1 ? 'approved' : 'declined') }}
									</span>
									<h2>{{ __('Invoice') }}</h2>
									<div class="invoice-number">Order {{ $order->invoice_no }}</div>
								</div>

								<hr>
								<div class="row">
									<div class="col-md-6">
										<address>
											<strong>{{ __('Billed To:') }}</strong><br>
											{{ __('Name: ') }} {{ $order->user->name ?? ''}}<br>
											{{ __('Address: ') }} {{ $order->user->address ?? '' }}<br>
											{{ __('Email: ') }} {{ $order->user->email ?? '' }}<br>
											{{ __('Phone: ') }} {{ $order->user->phone ?? '' }}<br>
										</address>
									</div>
									<div class="col-md-6 text-md-right">
										<address>
											<strong>{{ __('Billed From:') }}</strong><br>
											{{ $invoice_data->company_name }}<br />
											{{ $invoice_data->address }}<br />
											{{ $invoice_data->city }} <br />
											{{ $invoice_data->post_code }}<br />
											{{ $invoice_data->country }}
										</address>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<address>
											<strong>{{ __('Payment Method:') }}</strong><br>
											{{ __('Name:') }} {{ $order->gateway->name ?? '' }}<br>
											{{ __('Pay Id:') }} {{ $order->payment_id ?? '' }}<br>
										</address>
									</div>
									<div class="col-md-6 text-md-right">
										<address>

											<strong>{{ __('Order Date:') }}</strong> {{ $order->created_at->format('F d Y') }}<br>
											<strong>{{ __('Expire Date') }}:</strong> {{ Carbon\Carbon::parse($order->will_expire)->format('F d Y') }}<br>
										</address>

									</div>
								</div>
							</div>
						</div>

						<div class="row mt-4">
							<div class="col-md-12">

								<div class="table-responsive">
									<table class="table table-striped table-hover table-md">
										<tbody>
											<tr>

												<td class="col-9">{{ __('Subscription Plan Name') }}</td>
												<td class="col-3 text-right">{{ __('Amount') }}</td>
											</tr>
											<tr>
												<td>
													- {{ $order->plan->title ?? '' }}
												</td>
												<td class="text-right">{{ amount_format($order->amount,'name') }}</td>
											</tr>


										</tbody>
									</table>
								</div>
								<div class="row mt-4">
									<div class="col-lg-8">
										@if(!empty($order->meta))
										<div class="section-title">{{ __('Payment Info:') }}</div>
										<br>
										<p class="section-lead">{{ $order->meta['comment'] ?? '' }}</p>
										<p class="section-lead"><a target="_blank" href="{{ asset($order->meta['screenshot'] ?? '') }}">{{ __('Attachment') }}</a></p>
										@endif
									</div>
									<div class="col-lg-4 text-right">
										<div class="invoice-detail-item">
											<div class="invoice-detail-name">{{ __('Subtotal: ') }} {{ amount_format($order->amount,'name') }}</div>

										</div>
										<div class="invoice-detail-item">
											<div class="invoice-detail-name">{{ __('Tax: ') }} {{ amount_format($order->tax,'name') }}</div>

										</div>
										<hr class="mt-2 mb-2">
										<div class="invoice-detail-item">

											<div class="invoice-detail-value invoice-detail-value-lg">{{ __('Total: ') }} {{ amount_format($order->tax+$order->amount,'name') }}</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="text-md-right">
						<form method="POST" action="{{ route('admin.order.update',$order->id) }}" class="ajaxform">
							@csrf
							@method('PUT')
							<div class="row">
								
								<div class="form-group col-sm-3">
									<label class="float-left">{{ __('Order Status') }}</label>
									<select class="form-control" name="status">
										<option value="1" {{ $order->status == 1 ? 'selected' : '' }}>{{ __('Approved') }}</option>
										<option value="2" {{ $order->status == 2 ? 'selected' : '' }}>{{ __('Pending') }}</option>
										<option value="0" {{ $order->status == 0 ? 'selected' : '' }}>{{ __('Rejected') }}</option>
									</select>
								</div>
								<div class="form-group col-sm-3">
									<label class="float-left">{{ __('Assign This Plan?') }}</label>
									<select class="form-control" name="assign_order">
										<option value="yes">{{ __('Yes') }}</option>
										<option value="no" selected="">{{ __('No') }}</option>
										
									</select>
								</div>
								<div class="form-group">
									<br>
									<button class="btn btn-neutral btn-icon icon-left mt-2 submit-btn">{{ __('Update') }}</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection