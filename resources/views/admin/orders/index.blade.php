@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
	'title'=> __('Orders'),
	'buttons'=>[
	[
		'name'=> '<i class="fi fi-rs-file-invoice-dollar"></i>&nbsp&nbsp'.__('Invoice Settings'),
		'url'=>'#',
		'components'=>'data-toggle="modal" data-target="#addRecord" id="add_record"',
		'is_button'=>true
	],
	[
		'name'=> '<i class="fi fi-rs-money-check-edit"></i>&nbsp&nbsp'.__('Currency Settings'),
		'url'=>'#',
		'components'=>'data-toggle="modal" data-target="#currency" id="edit_currency"',
		'is_button'=>true
	],
	[
		'name'=> '<i class="fi fi-rs-bank"></i>&nbsp&nbsp'.__('Tax Settings'),
		'url'=>'#',
		'components'=>'data-toggle="modal" data-target="#tax" id="edit_tax"',
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
									{{ $totalOrders }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-boxes mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Orders') }}</h5>
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
									{{ $totalCompleteOrders }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-box-check mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Completed Orders') }}</h5>
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
									{{ $totalPendingOrders }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-calendar-clock mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Pending Orders') }}</h5>
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
									{{ $totalDeclinedOrders }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-remove-folder mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Rejected Orders') }}</h5>
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
				<h3 class="mb-0">{{ __('Orders') }}</h3>
				<form action="" class="card-header-form">
					<div class="input-group">
						<input type="text" name="search" value="{{ $request->search ?? '' }}" class="form-control" placeholder="Search......">
						<select class="form-control" name="type">
							<option value="email" @if($type == 'email') selected="" @endif>{{ __('User Email') }}</option>
							<option value="invoice_no" @if($type == 'invoice_no') selected="" @endif>{{ __('Invoice No') }}</option>
							
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
							<th class="col-1">{{ __('Order No') }}</th>
							<th class="col-4">{{ __('Plan Name') }}</th>
							<th class="col-2">{{ __('Payment Mode') }}</th>
							<th class="col-1">{{ __('Amount') }}</th>
							<th class="col-1">{{ __('Status') }}</th>
							<th class="col-1">{{ __('User') }}</th>
							<th class="col-1 text-left">{{ __('Created At') }}</th>
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
								<a href="{{ route('admin.customer.show',$order->user_id) }}" class="text-dark">{{ Str::limit($order->user->name ?? '',10) }}</a>
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
				{{ $orders->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
			</div>	
		</div>
	</div>
</div>


<div class="modal fade" id="addRecord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="{{ route('admin.option.update','invoice_data') }}" class="ajaxform">
            @csrf
            @method("PUT")
            <div class="modal-header">
               <h3>{{ __('Edit Invoice Information') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Company Name') }}</label>
                  <input type="text" name="data[company_name]" value="{{ $invoice->company_name ?? '' }}" class="form-control" required="">
               </div>
                <div class="form-group">
                  <label>{{ __('Company Address') }}</label>
                  <input type="text" name="data[address]" value="{{ $invoice->address ?? '' }}" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>{{ __('Company City') }}</label>
                  <input type="text" name="data[city]" value="{{ $invoice->city ?? '' }}" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>{{ __('Post Code') }}</label>
                  <input type="text" name="data[post_code]" value="{{ $invoice->post_code ?? '' }}" class="form-control" required="">
               </div>
                <div class="form-group">
                  <label>{{ __('Country') }}</label>
                  <input type="text" name="data[country]" value="{{ $invoice->country ?? '' }}" class="form-control" required="">
               </div>
              
               <div class="form-group">
               	<input type="hidden" name="is_array" value="1">
               <button type="submit" class="btn btn-neutral col-4 float-left submit-button" >{{ __('Update') }}</button>
               </div>
            </div>
            <div class="modal-footer">
      		</div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="currency" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="{{ route('admin.option.update','base_currency') }}" class="ajaxform">
            @csrf
            @method("PUT")
            <div class="modal-header">
               <h3>{{ __('Currency Settings') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Currency Name') }}</label>
                  <input type="text" name="data[name]" value="{{ $currency->name ?? '' }}" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>{{ __('Currency Icon') }}</label>
                  <input type="text" name="data[icon]" value="{{ $currency->icon ?? '' }}" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>{{ __('Currency Icon') }}</label>
                  <select class="form-control" name="data[position]">
                  	<option value="left" {{ $currency->position == 'left' ? 'selected' : '' }}>{{ __('Left') }}</option>
                  	<option value="right" {{ $currency->position == 'right' ? 'selected' : '' }}>{{ __('Right') }}</option>
                  </select>
               </div>
               <div class="form-group">
               	<input type="hidden" name="is_array" value="1">
               <button type="submit" class="btn btn-neutral col-4 float-left submit-button" >{{ __('Update') }}</button>
               </div>
            </div>
            <div class="modal-footer">
      		</div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="tax" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="{{ route('admin.option.update','tax') }}" class="ajaxform">
            @csrf
            @method("PUT")
            <div class="modal-header">
               <h3>{{ __('Tax Settings') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Tax Amount') }}</label>
                  <input type="number" step="any" name="data" value="{{ $tax }}" class="form-control" required="">
               </div>
               
               <div class="form-group">
              
               <button type="submit" class="btn btn-neutral col-4 float-left submit-button" >{{ __('Update') }}</button>
               </div>
            </div>
            <div class="modal-footer">
      		</div>
         </form>
      </div>
   </div>
</div>
@endsection