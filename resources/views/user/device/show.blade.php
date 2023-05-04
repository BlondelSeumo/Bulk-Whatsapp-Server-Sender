@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['buttons'=>[
	[
		'name'=>'&nbsp'.__('Back'),
		'url'=> route('user.device.index'),
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
								   {{ number_format($totalUsed) }}
							    </span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
									<i class="fas fa-paper-plane"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Used') }}</h5>
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
									{{ number_format($todaysMessage) }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
									<i class="fas fa-paper-plane"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Todays Transactions') }}</h5>
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
								 {{ number_format($monthlyMessages) }}
							    </span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
									<i class="fas fa-paper-plane"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Last 30 days message') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
		</div>

		@if(count($posts ?? []) > 0)
		<div class="card">
			
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<table class="table col-12">
							<thead>
								<tr>
									<th class="col-3">{{ __('Device From') }}</th>
									<th class="col-4">{{ __('Device To') }}</th>
									<th class="col-2">{{ __('Request Type') }}</th>
									<th class="col-1">{{ __('Message Type') }}</th>
									<th class="col-2 text-center">{{ __('Requested At') }}</th>
								</tr>
							</thead>
							<tbody class="tbody">
								@foreach($posts ?? [] as $post)
									<tr>
										<td>
											{{ $post->from }}											
										</td>
										<td>
											{{ $post->to }}
										</td>
										<td>
											{{ $post->type }}
										</td>
										<td>
											{{ $post->template_id != null ? 'Template' : 'Plain Text' }}
										</td>
										<td class="text-right">
											<span>{{ $post->created_at->diffForHumans() }}</span> - {{ $post->created_at->format('d F Y') }}
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
		<div class="alert  bg-gradient-primary text-white"><span class="text-left">{{ __('Opps There Is No Transaction Found....') }}</span></div>
		@endif
	</div>
</div>
@endsection
