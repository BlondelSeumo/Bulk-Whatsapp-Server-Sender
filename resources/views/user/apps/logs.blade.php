@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['buttons'=>[
[
'name'=>'Back',
'url'=>route('user.apps.index'),
]
]])
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-12">
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
                                <i class="fas fa-mobile-alt"></i>
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
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="fas fa-signal"></i>
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
                        <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                            <i class="fas fa-power-off"></i>
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

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
        <table class="table table-flush">
            <tr>
             <th class="col-3">{{ __('Device From') }}</th>
             <th class="col-4">{{ __('Device To') }}</th>
             <th class="col-2">{{ __('Request Type') }}</th>
             <th class="col-1">{{ __('Requested At') }}</th>
             <th class="col-2 text-center">{{ __('Requested Date') }}</th>
            </tr>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->from ?? '' }}</td>
                <td>{{ $log->to }}</td>
                <td>{{ $log->template_id != null ? 'Template' : 'Plain Text' }}</td>
                <td class="text-right">{{ $log->created_at->diffForHumans() }}</td>
                <td class="text-right">
                   {{ $log->created_at->format('d F Y') }}
                </td>

            </tr>
            @endforeach

        </table>
    </div>
    {{ $logs->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
</div>
</div>  
</div>

</div>
@endsection