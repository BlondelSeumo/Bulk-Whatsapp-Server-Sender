@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['title'=> __('Message Transactions Logs')])
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
									{{ number_format($total_messages) }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-comment-sms mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Messages') }}</h5>
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
									{{ number_format($today_messages) }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-comment-arrow-down mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Todays Messages') }}</h5>
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
									{{ number_format($last30_messages) }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-calendar mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Last 30 days Messages') }}</h5>
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
				<h3 class="mb-0">{{ __('Templates') }}</h3>
				<form action="" class="card-header-form">
					<div class="input-group">
						<input type="text" name="search" value="{{ $request->search ?? '' }}" class="form-control" placeholder="Search......">
						<select class="form-control" name="type">
							<option value="email" @if($type == 'email') selected="" @endif>{{ __('User Email') }}</option>
							<option value="from" @if($type == 'from') selected="" @endif>{{ __('Message from') }}</option>
							<option value="to" @if($type == 'to') selected="" @endif>{{ __('Message To') }}</option>
														
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
							<th class="col-2">{{ __('User') }}</th>
							<th class="col-2">{{ __('Message From') }}</th>
							<th class="col-2">{{ __('Message To') }}</th>
							<th class="col-2">{{ __('Message Type') }}</th>
							<th class="col-2">{{ __('Request Type') }}</th>
							<th class="col-1 text-left">{{ __('Created At') }}</th>
							<th class="col-1 text-left">{{ __('Action') }}</th>
						</tr>
					</thead>
					@if(count($transactions) != 0)
					<tbody class="list">
						@foreach($transactions ?? [] as $transaction)
						<tr>
							<td class="text-left">
								<a class="text-dark" href="{{ route('admin.customer.show',$transaction->user_id) }}">
									{{ $transaction->user->name }}
								</a>
							</td>
							<td>
								{{ $transaction->from }}
							</td>
							<td>
								{{ $transaction->to }}
							</td>

							<td class="text-center">
								{{ $transaction->template != null ? __('Template') : __('Plain Text') }}
							</td>
							
							<td>
								{{ $transaction->type }}
							</td>
							
							<td class="text-center">
								{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-F-Y') }}
							</td>
							<td>
								
								<div class="dropdown">
									<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										
										<a class="dropdown-item delete-confirm" href="#" data-action="{{ route('admin.message-transactions.destroy',$transaction->id) }}">{{ __('Remove') }}</a>
										
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
					@endif
				</table>
				@if(count($transactions) == 0)
				<div class="text-center mt-2">
					<div class="alert  bg-gradient-primary text-white">
						<span class="text-left">{{ __('!Opps no records found') }}</span>
					</div>
				</div>
				@endif
			</div>
			<div class="card-footer py-4">
				{{ $transactions->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
			</div>	
		</div>
	</div>
</div>
@endsection