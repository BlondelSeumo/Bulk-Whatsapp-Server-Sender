@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['buttons'=>[
[
'name'=>'Back',
'url'=> route('user.schedule-message.index'),
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
								<span class="h2 font-weight-bold mb-0 total-transfers">{{ number_format($info->schedulecontacts_count ?? 0) }}</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
									<i class="ni ni-bullet-list-67"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Contacts') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<span class="h2 font-weight-bold mb-0 total-transfers">{{ $info->device->phone ?? '' }}</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
									<i class="ni ni-time-alarm"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Phone Number (from)') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<span class="h2 font-weight-bold mb-0 completed-transfers">{{ Ucwords($info->status)  }}</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
									<i class="ni ni-chart-pie-35"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Schedule Status') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
		</div>


		<div class="card">
			<div class="card-header">
				<h4>{{ __('Receivers') }}</h4>
			</div>
			<div class="card-body">
				<div class="col-sm-12 table-responsive">
					<table class="table col-12">
						<thead>
							<tr>
								<td>{{ __('From') }}</td>
								<td>{{ __('Name') }}</td>
								<td>{{ __('Number') }}</td>
								<td>{{ __('Delivery Date') }}</td>
							</tr>
						</thead>
						<tbody class="tbody">
							@foreach($contacts ?? [] as $contact)
							<tr>
								<td>{{ $info->device->phone ?? '' }}</td>
								<td>{{ $contact->contact->name ?? '' }}</td>
								<td>{{ $contact->contact->phone ?? '' }}</td>
								<td>{{ Carbon\Carbon::parse($info->date)->format('d-F-Y')  }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div class="d-flex justify-content-center">{{ $contacts->links('vendor.pagination.bootstrap-4') }}</div>
				</div>

			</div>
		</div>
	</div>
</div>					
@endsection