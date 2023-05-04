@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['title'=> __('SEO Settings')])
@endsection
@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<!-- Card header -->
			<div class="card-header border-0">
				<h3 class="mb-0">{{ __('SEO List') }}</h3>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th class="col-2">{{ __('Page') }}</th>
							<th class="col-2">{{ __('Meta Title') }}</th>							
							<th class="col-8 text-right">{{ __('Action') }}</th>
						</tr>
					</thead>					
						@foreach($posts as $seo)

						<tr>
							<td class="text-left">
								{{ $seo['key'] }}
							</td>
							<td class="text-left">
								{{ $seo['content']->site_name ?? '' }}
							</td>
							
							<td class="text-right">
								<a href="{{ route('admin.seo.edit',$seo['id']) }}" class="btn btn-neutral btn-sm"><i class="fas fa-edit"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>				
			</div>			
		</div>
	</div>
</div>
@endsection