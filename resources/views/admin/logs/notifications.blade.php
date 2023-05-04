@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Notifications'),
'buttons'=>[
   [
      'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create Notification'),
      'url'=>'#',
      'components'=>'data-toggle="modal" data-target="#addRecord" id="add_record"',
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
									{{ $totalNotifications }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-envelope-bulk mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Notifications') }}</h5>
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
									{{ $readNotifications }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-envelope-open mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Read Notifications') }}</h5>
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
									{{ $unreadNotifications }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-envelope-ban mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Unread Notifications') }}</h5>
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
							<option value="title" @if($type == 'title') selected="" @endif>{{ __('title') }}</option>
														
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
							<th class="col-3">{{ __('Title') }}</th>
							<th class="col-5">{{ __('Comment') }}</th>
							<th class="col-1">{{ __('User') }}</th>
							<th class="col-1">{{ __('Seen') }}</th>
							<th class="col-1 text-left">{{ __('Created At') }}</th>
							<th class="col-1 text-left">{{ __('Action') }}</th>
						</tr>
					</thead>
					@if(count($notifications) != 0)
					<tbody class="list">
						@foreach($notifications ?? [] as $notification)
						<tr>
							<td class="text-left">
								{{ Str::limit($notification->title,80) }}
							</td>
							<td>
								{{ Str::limit($notification->comment,50) }}
							</td>
							<td>
	       						<a class="text-dark" href="{{ route('admin.customer.show',$notification->user_id) }}">
									{{ Str::limit($notification->user->name ?? '',15) }}
								</a>
							</td>
							
							<td>
								<span class="badge badge-{{ $notification->seen == 1 ? 'success' : 'danger' }}">
									{{ $notification->seen == 1 ? 'Read' : 'Unread' }}
								</span>
							</td>
							
							<td class="text-center">
								{{ \Carbon\Carbon::parse($notification->created_at)->format('d-F-Y') }}
							</td>
							<td>
								
								<div class="dropdown">
									<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										
										<a class="dropdown-item delete-confirm" href="#" data-action="{{ route('admin.notification.destroy',$notification->id) }}">{{ __('Remove') }}</a>
										
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
					@endif
				</table>
				@if(count($notifications) == 0)
				<div class="text-center mt-2">
					<div class="alert  bg-gradient-primary text-white">
						<span class="text-left">{{ __('!Opps no records found') }}</span>
					</div>
				</div>
				@endif
			</div>
			<div class="card-footer py-4">
				{{ $notifications->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
			</div>	
		</div>
	</div>
</div>

<div class="modal fade" id="addRecord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="{{ route('admin.notification.store') }}" class="ajaxform_instant_reload">
            @csrf
            <div class="modal-header">
               <h3>{{ __('Send Notification') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Receive Email') }}</label>
                  <input type="email" name="email" class="form-control" required>
               </div>
               <div class="form-group">
                  <label>{{ __('Title') }}</label>
                  <input type="text" name="title" class="form-control" required maxlength="100">
               </div>
               <div class="form-group">
                  <label>{{ __('Description') }}</label>
                  <textarea class="form-control" required="" name="description" maxlength="200"></textarea>
               </div>
               <div class="form-group">
                  <label>{{ __('Action Link') }}</label>
                  <input type="url" name="url" class="form-control" required maxlength="100">
               </div>
               
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-outline-primary col-12" >{{ __('Create Now') }}</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection