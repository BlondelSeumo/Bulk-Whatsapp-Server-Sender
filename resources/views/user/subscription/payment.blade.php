@extends('gateways.main')
@section('content')
<div class="col-sm-12">
   <table class="header">
      <tr>
         <td width="50%" nowrap>
            <p><img width="50%" height="50%" src="{{ asset(get_option('primary_data',true)->logo ?? '') }}" title="" /></p>
         </td>
         <td width="50%" align="right">
            <font class="unpaid">{{ __('Unpaid') }}</font><br />
         </td>
      </tr>
   </table>
</div>
@if(Session::has('error'))
<div class="col-sm-12">
   <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <span class="alert-icon"><i class="fas fa-sad-tear"></i></span>
    <span class="alert-text"><strong>{{ __('!Opps ') }}</strong> {{ __('Transaction failed if you make payment successfully please contact us.') }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
   </button>
</div>
</div>
@endif
@if(Session::has('min-max'))
<div class="col-sm-12">
   <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <span class="alert-icon"><i class="fas fa-sad-tear"></i></span>
    <span class="alert-text"><strong>{{ __('!Opps ') }}</strong> {{ Session::get('min-max') }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
   </button>
</div>
</div>
@endif
@if(Session::has('errors'))
@foreach ($errors->all() as $error)
<div class="col-sm-12">
   <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <span class="alert-icon"><i class="fas fa-sad-tear"></i></span>
    <span class="alert-text">{{ $error }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
   </button>
</div>
</div>
@endforeach
@endif
<div class="row">
   @foreach($gateways as $key => $gateway)
   <div class="radiocontainer gateways col-sm-4">
      <input id="gateway_{{ $gateway->id }}" class="gateway-button" type="radio" name="paymentmethod" value="{{$gateway->id}}" {{ $key == 0 ? 'checked' : '' }} data-target="#gateway-form{{ $gateway->id }}" />
      <label for="gateway_{{ $gateway->id }}"><img src="{{ asset($gateway->logo) }}" class="gateway-img"/></label>
   </div>
   @endforeach 
</div>
<div class="clear"></div>
@foreach($gateways as $key => $gateway)
<div class="col-sm-12 {{ $key != 0 ? 'none' : '' }} gateway-form" id="gateway-form{{ $gateway->id }}">
   <form method="post" action="{{ url('user/make-subscribe/'.$gateway->id.'/'.$plan->id) }}" class="ajaxform_next_page" enctype="multipart/form-data">
      @csrf
      <div class="table-responsive">
         <table class="items table">
            <tr>
               <td>
                  {{ __('Method Name: ') }}
               </td>
               <td class="textcenter">
                  {{ $gateway->name }}
               </td>
            </tr>
            @if($gateway->currency != null)
            <tr>
               <td>
                  {{ __('Gateway Currency: ') }}
               </td>
               <td class="textcenter">
                  {{ strtoupper($gateway->currency) }}
               </td>
            </tr>
            @endif
            @if($gateway->charge != 0)
            <tr>
               <td>
                  {{ __('Gateway Charge: ') }}
               </td>
               <td class="textcenter">
                  {{ $gateway->charge }}
               </td>
            </tr>
            @endif
            <tr>
               <td>
                  {{ __('Payble Amount: ') }}
               </td>
               <td class="textcenter">
                  {{ $total*$gateway->multiply+$gateway->charge }}
               </td>
            </tr>
         </table>
         @if($gateway->comment != null)
         <table class="table mt-2 items">
            <tr>
               <td>
                  {{ __('Payment Instruction: ') }}                                           
               </td>
            </tr>
            <tr>
               <td>{{ $gateway->comment }}</td>
            </tr>
         </table>
         @endif
         @if($gateway->phone_required == 1)
         <div class="form-group mt-2">
            <label><b>{{ __('Your phone number') }}</b></label>
            <input type="number" name="phone" class="form-control" required="" value="{{ Auth::user()->phone }}">
         </div>
         @endif
         @if($gateway->is_auto == 0)
         <div class="form-group mt-2">
            <label><b>{{ __('Submit your payment proof') }}</b></label>
            <input type="file" name="image" class="form-control" required="" accept="image/*">
         </div>
         <div class="form-group">
            <label><b>{{ __('Comment') }}</b></label>
            <textarea class="form-control" required="" name="comment" maxlength="500"></textarea>
         </div>
         @endif
      </div>
      <button class="btn btn-neutral  col-12 submit-button mb-2 mt-2">{{ __('Pay Now') }}</button>
   </form>
</div>
@endforeach
<br>
<div class="col-sm-12">

   <table class="address table " cellspacing="8">
      <tr>
         <td class="col-6">
            <div class="addressbox">
               <strong>{{ __('Invoiced To') }}</strong><br />
               {{ Auth::user()->name }}<br />
               {{ Auth::user()->address }}
            </div>
         </td>
         <td class="col-6">
            <div class="addressbox">
               <strong>{{ __('Pay To') }}</strong><br />
               {{ $invoice_data->company_name }}<br />
               {{ $invoice_data->address }}<br />
               {{ $invoice_data->city }} <br />
               {{ $invoice_data->post_code }}<br />
               {{ $invoice_data->country }}
            </div>
         </td>
      </tr>
   </table>

   <table class="items table mt-2">
      <tr class="title textcenter">
         <td class="col-9">{{ __('Description') }}</td>
         <td class="col-3">{{ __('Amount') }}</td>
      </tr>
      <tr>
         <td>
            - {{ $plan->title }}
         </td>
         <td class="textcenter">{{ amount_format($plan->price,'name') }}</td>
      </tr>
      <tr class="title">
         <td class="textright">{{ __('Sub Total') }}:</td>
         <td class="textcenter">{{ amount_format($plan->price,'name') }}</td>
      </tr>
      <tr class="title">
         <td class="textright">{{ __('Tax') }}:</td>
         <td class="textcenter">{{ amount_format($tax,'name') }}</td>
      </tr>
      <tr class="title">
         <td class="textright">Total:</td>
         <td class="textcenter">{{ amount_format($total,'name') }}</td>
      </tr>
   </table>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/js/pages/user/subscription-pay.js') }}"></script>
@endpush
