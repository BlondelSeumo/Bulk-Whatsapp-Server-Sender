@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Plans'),
'buttons'=>[
	[
		'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create A Plan'),
		'url'=>route('admin.plan.create'),
	]
]
])
@endsection
@section('content')
<div class="row">
	@foreach($plans as $plan)
	<div class="col-md-6 col-lg-3 text-center">
		<div class="card">
			<div class="card-body">
				<h2 class="pricing-green">{{ $plan->title }}</h2>
				<h1>{{ amount_format($plan->price) }}</h1>
				{{ $plan->days == 30 ? 'Per month' : 'Per year' }}
				<br>
				<span href="#!" class="text-muted">{{ __('Active Users') }} ({{ $plan->activeuser_count }})</span>
				<hr>
				@foreach($plan->data ?? [] as $key => $data)
				<div class="mt-2 text-left">
					@if(planData($key,$data)['is_bool'] == true)
					@if(planData($key,$data)['value'] == true)
					<i class="{{ planData($key,$data)['value'] == true ? 'far text-success fa-check-circle' : 'fas text-danger fa-times-circle' }}"></i> 
					@else
					<i class="fas text-danger fa-times-circle"></i> 
					@endif

					@else
					<i class="far text-success fa-check-circle"></i> 
					@endif      
					{{ str_replace('_',' ',planData($key,$data)['title']) }}
				</div>
				@endforeach
				<hr>
				<div class="mt-2">
					<div class="text-center">
						<a class="btn btn-sm  btn-neutral text-left" href="{{ route('admin.plan.edit',$plan->id) }}"  data-icon="fa fa-plus-circle">
							<i class="fa fa-edit" aria-hidden="true"></i>
						</a>
						
						<a class="btn btn-sm btn-primary text-left delete-confirm" href="#" data-action="{{ route('admin.plan.destroy',$plan->id) }}" data-icon="fa fa-plus-circle">
							<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
					</div>

					
				</div>
			</div>
		</div>
	</div>
	@endforeach

	@if(count($plans) == 0)
		<div class="alert  bg-gradient-primary text-white col-sm-12"><span class="text-left">{{ __('Opps you have not created any plan....') }}</span></div>
	@endif
</div>
@endsection