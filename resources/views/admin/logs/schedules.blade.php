@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['title'=> __('Schedules')])
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
									{{ $totalSchedules }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-calendars mt-2"></i>
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
								<span class="h2 font-weight-bold mb-0 total-transfers" id="total-active">
									{{ $pendingSchedules }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-calendar-clock mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Upcoming Schedules') }}</h5>
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
									{{ $deliveredSchedules }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-calendar-check mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Executed Schedules') }}</h5>
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
				<h3 class="mb-0">{{ __('Schedules') }}</h3>
				<form action="" class="card-header-form">
					<div class="input-group">
						<input type="text" name="search" value="{{ $request->search ?? '' }}" class="form-control" placeholder="Search......">
						<select class="form-control" name="type">
							<option value="email" @if($type == 'email') selected="" @endif>{{ __('User Email') }}</option>
							<option value="title" @if($type == 'title') selected="" @endif>{{ __('Schedule Name') }}</option>
														
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
							<th class="col-2">{{ __('Name') }}</th>
							<th class="col-4">{{ __('User') }}</th>
							<th class="col-2">{{ __('Device') }}</th>
							<th class="col-1">{{ __('Total Receivers') }}</th>
							<th class="col-1">{{ __('Status') }}</th>
							<th class="col-1 text-left">{{ __('Schedule Date') }}</th>
							<th class="col-1 text-left">{{ __('Action') }}</th>
						</tr>
					</thead>
					@if(count($schedulemessages) != 0)
					<tbody class="list">
						@foreach($schedulemessages ?? [] as $schedulemessage)
						<tr>
							<td class="text-left">
								{{ $schedulemessage->title }}
							</td>
							<td>
								<a class="text-dark" href="{{ route('admin.customer.show',$schedulemessage->user_id) }}">
									{{ Str::limit($schedulemessage->user->name ?? '',15) }}
								</a>
							</td>
							<td>
	       						{{ $schedulemessage->device->phone ?? '' }}
							</td>

							<td class="text-center">
								{{ number_format($schedulemessage->schedulecontacts_count) }}
							</td>
							
							<td>
								<span class="badge {{ badge($schedulemessage->status)['class'] }}">{{ $schedulemessage->status }}</span>
							</td>
							
							<td class="text-center">
								{{ \Carbon\Carbon::parse($schedulemessage->date)->format('d-F-Y') }}
							</td>
							<td>
								
								<div class="dropdown">
									<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										
										<a class="dropdown-item delete-confirm" href="#" data-action="{{ route('admin.schedules.destroy',$schedulemessage->id) }}">{{ __('Remove') }}</a>
										
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
					@endif
				</table>
				@if(count($schedulemessages) == 0)
				<div class="text-center mt-2">
					<div class="alert  bg-gradient-primary text-white">
						<span class="text-left">{{ __('!Opps no records found') }}</span>
					</div>
				</div>
				@endif
			</div>
			<div class="card-footer py-4">
				{{ $schedulemessages->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
			</div>	
		</div>
	</div>
</div>
@endsection