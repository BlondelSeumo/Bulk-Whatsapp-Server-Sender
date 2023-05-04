@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['title'=> __('Supports')])
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
									{{ $totalSupports }}
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
									<i class="fi fi-rs-time-forward mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Pending Supports') }}</h5>
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
									{{ $closedSupport }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-comment-slash mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Closed Supports') }}</h5>
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
				<h3 class="mb-0">{{ __('Tickets') }}</h3>
				<form action="" class="card-header-form">
					<div class="input-group">
						<input type="text" name="search" value="{{ $request->search ?? '' }}" class="form-control" placeholder="Search......">
						<select class="form-control" name="type">
							<option value="email" @if($type == 'email') selected="" @endif>{{ __('User Email') }}</option>
							<option value="ticket_no" @if($type == 'ticket_no') selected="" @endif>{{ __('Ticket No') }}</option>
							<option value="subject" @if($type == 'subject') selected="" @endif>{{ __('Subject') }}</option>
						</select>
						<div class="input-group-btn">
							<button class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
						</div>
					</div>
				</form>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th class="col-1">{{ __('Ticket No') }}</th>
							<th class="col-6">{{ __('Subject') }}</th>
							<th class="col-1">{{ __('Conversations') }}</th>
							<th class="col-1">{{ __('Status') }}</th>
							<th class="col-1">{{ __('User') }}</th>
							<th class="col-1 text-left">{{ __('Created At') }}</th>
							<th class="col-1 text-left">{{ __('Ticket') }}</th>
						</tr>
					</thead>
					@if(count($supports) != 0)
					<tbody class="list">
						@foreach($supports ?? [] as $support)
						<tr>
							<td class="text-center">
								{{ $support->ticket_no }}
							</td>
							<td>
								<a class="text-dark" href="{{ route('admin.support.show',$support->id) }}">
									{{ Str::limit($support->subject,50) }}
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
							<td class="text-center">
								<a href="{{ route('admin.customer.show',$support->user_id) }}" class="text-dark">{{ Str::limit($support->user->name ?? '',10) }}</a>
							</td>
							<td class="text-center">
								{{ $support->created_at->format('d F y') }}
							</td>
							<td>
								<a href="{{ route('admin.support.show',$support->id) }}" class="btn btn-neutral btn-sm">{{ __('View Ticket') }}</a>
							</td>
						</tr>
						@endforeach
					</tbody>
					@endif
				</table>
				@if(count($supports) == 0)
				<div class="text-center mt-2">
					<div class="alert  bg-gradient-primary text-white">
						<span class="text-left">{{ __('!Opps no support query found') }}</span>
					</div>
				</div>
				@endif
			</div>
			<div class="card-footer py-4">
				{{ $supports->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
			</div>	
		</div>
	</div>
</div>
@endsection