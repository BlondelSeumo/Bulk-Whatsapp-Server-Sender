@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Pages'),
'buttons'=>[
	[
		'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create a team'),
		'url'=>route('admin.team.create'),
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
									{{ $totalPosts }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-users-alt mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Members') }}</h5>
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
									{{ $totalActivePosts }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-comment-user mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Active Members') }}</h5>
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
									{{ $totalInActivePosts }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-delete-user mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Inactive Members') }}</h5>
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
				<h3 class="mb-0">{{ __('Our Team') }}</h3>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th class="col-5">{{ __('Name') }}</th>
							<th class="col-2">{{ __('Position') }}</th>
							
							<th class="col-3 text-right">{{ __('Status') }}</th>
							<th class="col-2 text-right">{{ __('Action') }}</th>
						</tr>
					</thead>					
						@foreach($posts ?? [] as $post)
						<tr>
							<td class="text-left">
								<img src="{{ asset($post->preview->value) }}" class="avatar rounded-square mr-3">
								{{ Str::limit($post->title,50) }}
							</td>
							<td class="text-left">
								{{ Str::limit($post->slug,50) }}
							</td>
							
							
							<td class="text-right">
								<span class="badge badge-{{ $post->status == 1 ? 'success' : 'danger' }}">
									{{ $post->status == 1 ? __('Active') : __('Draft') }}
								</span>
							</td>
							
							<td class="text-right">
								<div class="btn-group mb-2 float-right">
									<button class="btn btn-neutral btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										{{ __('Action') }}
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item has-icon" href="{{ route('admin.team.edit',$post->id) }}"><i class="fi fi-rs-edit"></i>{{ __('Edit') }}</a>
										

										<a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-action="{{ route('admin.team.destroy',$post->id) }}"><i class="fas fa-trash"></i>{{ __('Remove Member') }}</a>
									</div>
								</div>								
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@if(count($posts) == 0)
				<div class="text-center mt-2">
					<div class="alert  bg-gradient-primary text-white">
						<span class="text-left">{{ __('!Opps no records found') }}</span>
					</div>
				</div>
				@endif				
			</div>
			<div class="card-footer py-4">
				{{ $posts->links('vendor.pagination.bootstrap-5') }}
			</div>					
		</div>
	</div>
</div>
@endsection