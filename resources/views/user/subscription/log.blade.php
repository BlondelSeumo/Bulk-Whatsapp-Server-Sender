@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'   => __('Subscription Plan'),
'buttons' => [
	 [
      'name'=> __('Back'),
      'url'=> url('/user/subscription'),
   ]
]

])
@endsection
@section('content')
<div class="row justify-content-center">
     <div class="col-12">
        @if(count($orders ?? []) == 0)
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <center>
                        <img src="{{ asset('assets/img/404.jpg') }}" height="500">
                        <h3 class="text-center">{{ __('!Opps You Have Not Created Any Order Now') }}</h3>
                    </center>
                </div>
            </div>
        </div>
        @else
        <div class="card">
            
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table col-12">
                            <thead>
                                <tr>
                                    <th>{{ __('Order No') }}</th>
                                    <th>{{ __('Plan Name') }}</th>
                                    <th>{{ __('Payment Method') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Staus') }}</th>
                                    <th class="text-right">{{ __('Order Date') }}</th>
                                    <th class="text-right">{{ __('Will Expire') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @foreach($orders ?? [] as $log)
                                    <tr>
                                        <td>
                                            {{ $log->invoice_no }}
                                        </td>
                                        <td>
                                            {{ $log->plan->title ?? '' }}
                                        </td>
                                        <td>
                                            {{ $log->gateway->name ?? '' }}
                                        </td>

                                        <td>
                                            {{ amount_format($log->amount) }}
                                        </td>
                                        <td>
                                            <span class="badge {{ badge($log->status)['class'] }}">
                                                {{ badge($log->status)['text'] }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            {{ $log->created_at->format('d F Y') }}
                                        </td>
                                        <td class="text-right">
                                            {{ \Carbon\Carbon::parse($log->will_expire)->format('d F Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">{{ $orders->links('vendor.pagination.bootstrap-4') }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection