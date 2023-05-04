@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=>__('Device'),
'buttons'=>[
	[
		'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create Support Request'),
		'url'=> route('user.support.create'),
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
								  {{ $total }}
							    </span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-tickets-airline mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Tickets') }}</h5>
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
									{{ $openSupport }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-ticket-airline mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Open Tickets') }}</h5>
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
								  {{ $pendingSupport }}
							    </span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-ticket-alt mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Pending Supports') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
		</div>

		@if(count($supports ?? []) > 0)
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<table class="table col-12">
							<thead>
								<tr>
									<th class="col-8">{{ __('Subject') }}</th>
									<th class="col-1">{{ __('Conversations') }}</th>
									<th class="col-1">{{ __('Status') }}</th>
									<th class="col-1 text-left">{{ __('Created At') }}</th>
									<th class="col-1 text-left">{{ __('Ticket') }}</th>
								</tr>
							</thead>
							<tbody class="tbody">
								@foreach($supports ?? [] as $support)
									<tr>
										<td>
											<a class="text-dark" href="{{ route('user.support.show',$support->id) }}">
												{{ $support->subject }}
											</a>
										</td>
										<td class="text-center">
											{{ $support->conversations_count }}
										</td>
										<td>
											<span class="badge badge-{{ $support->status == 2 ? 'warning' : ($support->status == 1 ? 'success' : 'danger') }}">
											  {{ $support->status == 2 ? 'pending' : ($support->status == 1 ? 'Open' : 'Closed') }}
											</span>
										</td>
										<td class="text-center">{{ $support->created_at->format('d F y') }}</td>
										<td>
											<a href="{{ route('user.support.show',$support->id) }}" class="btn btn-neutral btn-sm">{{ __('View Ticket') }}</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<div class="d-flex justify-content-center">{{ $supports->links('vendor.pagination.bootstrap-4') }}</div>
					</div>
				</div>
			</div>
		</div>
		@else
		<div class="alert  bg-gradient-primary text-white"><span class="text-left">{{ __('Opps you have not created any support now....') }}</span></div>
		@endif
	</div>
</div>
@endsection
