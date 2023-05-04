@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Pages'),
'buttons'=>[
	[
		'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create a page'),
		'url'=>route('admin.page.create'),
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
									<i class="fi  fi-rs-document-signed mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Pages') }}</h5>
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
									<i class="fi fi-rs-assept-document mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Active Pages') }}</h5>
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
									<i class="fi fi-rs-delete-document mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Inactive Pages') }}</h5>
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
				<h3 class="mb-0">{{ __('Pages') }}</h3>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th class="col-2">{{ __('Title') }}</th>
							<th class="col-4">{{ __('Url') }}</th>
							<th class="col-1">{{ __('Status') }}</th>
							<th class="col-2">{{ __('Created At') }}</th>
							<th class="col-1 text-right">{{ __('Action') }}</th>
						</tr>
					</thead>					
						@foreach($pages ?? [] as $page)
						<tr>
							<td class="text-left">
								{{ Str::limit($page->title,50) }}
							</td>
							<td class="text-left">
								<a href="{{ url('page/'.$page->slug) }}" target="_blank">{{ Str::limit(url('page/'.$page->slug),100) }}</a>
							</td>
							
							<td class="text-left">
								<span class="badge badge-{{ $page->status == 1 ? 'success' : 'danger' }}">
									{{ $page->status == 1 ? __('Active') : __('Draft') }}
								</span>
							</td>
							<td>
								{{ $page->created_at->format('F-d-Y') }}
							</td>
							<td class="text-right">
								<div class="btn-group mb-2 float-right">
									<button class="btn btn-neutral btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										{{ __('Action') }}
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item has-icon" href="{{ route('admin.page.edit',$page->id) }}"><i class="fi fi-rs-edit"></i>{{ __('Edit') }}</a>
										

										<a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-action="{{ route('admin.page.destroy',$page->id) }}"><i class="fas fa-trash"></i>{{ __('Remove Page') }}</a>
									</div>
								</div>								
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@if(count($pages) == 0)
				<div class="text-center mt-2">
					<div class="alert  bg-gradient-primary text-white">
						<span class="text-left">{{ __('!Opps no records found') }}</span>
					</div>
				</div>
				@endif				
			</div>

			<div class="card-footer py-4">
				{{ $pages->links('vendor.pagination.bootstrap-5') }}
			</div>			
		</div>
	</div>
</div>
@endsection