@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'   => __('Schedule Message'),
'buttons' =>[
	[
	'name'=>'<i class="ni ni-calendar-grid-58"></i>&nbspCreate Schedule',
	'url'=> route('user.schedule-message.create'),
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
								<span class="h2 font-weight-bold mb-0 total-transfers">{{ number_format($totalSchedule ?? 0) }}</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="ni ni-calendar-grid-58 "></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Schedules') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<span class="h2 font-weight-bold mb-0 total-transfers">{{ number_format($pendingSchedule ?? 0) }}</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-calendar-clock mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Pending Schedules') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<span class="h2 font-weight-bold mb-0 completed-transfers">{{ number_format($deliveredSchedule?? 0)  }}</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-rocket-lunch mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Schedules Executed') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<span class="h2 font-weight-bold mb-0 pending-transfers">{{ number_format($failedSchedule ?? 0) }}</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-calendar-xmark mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Failed Schedules') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
		</div>
		@if(getUserPlanData('schedule_message') == false)
		<div class="row">
			<div class="col-sm-12">
				<div class="alert bg-gradient-primary text-white alert-dismissible fade show" role="alert">
					<span class="alert-icon"><i class="fi  fi-rs-info text-white"></i></span>
					<span class="alert-text">
						<strong>{{ __('!Opps ') }}</strong> 

						{{ __('Schedule Message features is not available in your subscription plan') }}
						
					</span>
				</div>
			</div>
		</div>
		@endif

		@if(count($posts) > 0)
		<div class="card">
			
			<div class="card-body">
				<h3>{{ __('Schedules') }}</h3>
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<table class="table col-12">
							<thead>
								<tr>
									<th class="col-3">{{ __('Send From') }}</th>
									<th class="col-4">{{ __('Title') }}</th>
									<th class="col-1">{{ __('Message Type') }}</th>
									<th class="col-1">{{ __('Status') }}</th>
									<th class="col-1">{{ __('Delivery Date') }}</th>
									<th class="col-2">{{ __('Action') }}</th>
								</tr>
							</thead>
							<tbody class="tbody">
								@foreach($posts as $post)
									<tr>
										<td>{{ $post->device->phone ?? '' }}</td>
										<td>{{ Str::limit($post->title ?? '',90)  }}</td>
										<td class="text-center">{{ $post->body !=  null ? 'Plain Text' : 'Template'  }}</td>
										<td><span class="badge {{ badge($post->status)['class'] }}">{{ $post->status }}</span></td>
										<td>{{ $post->date }}</td>
										<td>
											<div class="btn-group mb-2">
												<button class="btn btn-neutral btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													{{ __('Action') }}
												</button>
												<div class="dropdown-menu">

													<a class="dropdown-item has-icon" href="{{ route('user.schedule-message.show',$post->id) }}"><i class="ni ni-align-left-2"></i>{{ __('View Log') }}</a>


													<a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-action="{{ route('user.schedule-message.destroy',$post->id) }}"><i class="ni ni-basket"></i>{{ __('Remove Schedule') }}</a>
													

												</div>
											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<div class="d-flex justify-content-center">{{ $posts->links('vendor.pagination.bootstrap-4') }}</div>
					</div>
				</div>
			</div>
		</div>
		@else
		<div class="alert  bg-gradient-primary text-white"><span class="text-left">{{ __('Opps There Is No Schedules Found....') }}</span></div>
		@endif
	</div>
</div>



<input type="hidden" id="base_url" value="{{ url('/') }}">
<input type="hidden" id="bulk_message_link" value="{{ route('user.bulk-message.store') }}">
@csrf
@endsection
@push('js')
<script src="{{ asset('assets/js/pages/bulk/jquery.csv.min.js') }}" ></script>
<script src="{{ asset('assets/js/pages/bulk/bulkmessage.js') }}" ></script>


@endpush