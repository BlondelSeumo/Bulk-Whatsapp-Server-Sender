@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=>__('Support'),
'buttons'=>[
	[
		'name'=>__('Back'),
		'url'=> route('user.support.index'),
	]
]])
@endsection
@section('content')
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow">
				<div class="card-header">
					<div class="row">
						<h3 class="mb-0 font-weight-bolder">{{ __('Subject :') }} {{ $support->subject }}</h3>
					</div>
				</div>
				<div class="card-body">
					<div class="timeline timeline-one-side" data-timeline-content="axis"
					data-timeline-axis-style="dashed">
					
					@foreach($support->conversations ?? [] as $reply)
					<div class="timeline-block">
						<span class="timeline-step badge-primary">
							<i class="{{ $reply->is_admin == 0 ? 'fi fi-rs-paper-plane' : 'fi  fi-rs-headset' }}"></i>
						</span>
						<div class="timeline-content">
							<small class="text-xs">
								{{ $reply->created_at->format('d M, Y - h:i A') }} 
								{{ $reply->is_admin == 0 && $reply->seen == 1 ? '(Seen)' : '' }}
							</small>
							<h5 class="mt-3 mb-0">{{ $reply->comment }}</h5>
							<br>
							<b class="text-sm tt-5">{{ $reply->is_admin == 0 ? 'You' : 'Support Agent' }}</b>
						</div>
					</div>
					@endforeach
				</div></span>
			</div>
		</div>

		@if($support->status == 1)
		<div class="card shadow">
			<div class="card-body">
				<form method="POST" class="ajaxform_instant_reload" action="{{ route('user.support.update',$support->id) }}">
					@csrf
					@method('PUT')
					<div class="form-group">
						<label>{{ __('Reply') }}</label>
						<textarea class="form-control h-200" required="" name="message" maxlength="1000"></textarea>
					</div>
					<button class="btn btn-neutral"  {{ $support->status != 1 ? 'disabled' : ''  }}>{{ __('Submit') }}</button>
				</form>
			</div>
		</div>	
		@endif
	</div>
</div>
</div>        	

@endsection