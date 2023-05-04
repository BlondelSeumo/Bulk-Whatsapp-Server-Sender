@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['title'=> 'Messages log reports'])
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
									<i class="fi fi-rs-rocket-lunch mt-2"></i>
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
									{{ number_format($today_messages)  }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-calendar-day mt-2"></i>
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
									<i class="ni ni-calendar-grid-58"></i>
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

		@if(count($logs ?? []) == 0)
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-body">
						<center>
							<img src="{{ asset('assets/img/404.jpg') }}" height="500">
							<h3 class="text-center">{{ __('!Opps You Have Not Created Any Message Transactions') }}</h3>
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
									<th>{{ __('Message From') }}</th>
									<th>{{ __('Message To') }}</th>
									<th>{{ __('Message Type') }}</th>
									<th>{{ __('Request Type') }}</th>
									<th class="text-right">{{ __('Requested At') }}</th>
								</tr>
							</thead>
							<tbody class="tbody">
								@foreach($logs ?? [] as $log)
								<tr>
									<td>
										{{ $log->from }}
									</td>
									<td>
										{{ $log->to }}
									</td>
									<td>{{ $log->template != null ? 'Template' : 'Plain Text' }}</td>

									<td>
										{{ $log->type }}
									</td>
									<td class="text-right">
										{{ $log->created_at->format('d F Y') }}
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<div class="d-flex justify-content-center">{{ $logs->links('vendor.pagination.bootstrap-4') }}</div>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>


@endsection
