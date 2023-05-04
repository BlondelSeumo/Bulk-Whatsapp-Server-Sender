@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'   => __('Subscription Plan'),
'buttons' => [
	 [
      'name'=>'<i class="fi  fi-rs-calendar-clock"></i>&nbsp&nbsp'.__('Subscriptions History'),
      'url'=> url('/user/subscriptions/log'),
   ]
]

])
@endsection
@section('content')
<div class="row">
@if(Session::has('saas_error'))
 <div class="col-sm-12">
   <div class="alert bg-gradient-danger text-white alert-dismissible fade show" role="alert">
     <span class="alert-icon"><i class="fi  fi-rs-info"></i></span>
     <span class="alert-text"><strong>{{ __('!Opps ') }}</strong> {{ Session::get('saas_error') }}</span>
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>
</div>
@endif
	@foreach($plans as $plan)
	<div class="col-sm-4 text-center">
		<div class="card">
			<div class="card-body">
				<h2 class="pricing-green">{{ $plan->title }}</h2>
				<h1>{{ amount_format($plan->price) }}</h1>
				
				{{ $plan->days == 30 ? 'Per month' : 'Per year' }}
				
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
				<a class="btn btn-block  btn-neutral" href="{{ route('user.subscription.show',$plan->id) }}">
						<i class="{{  Auth::user()->plan_id == $plan->id ? 'fa fa-check' : 'fa fa-plus-circle' }} " ></i>
				 	{{ Auth::user()->plan_id == $plan->id ? __('Activated') :  __('Subscribe') }}
				</a>
			</div>
		</div>
	</div>
	@endforeach
</div>
@endsection