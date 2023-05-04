@extends('gateways.main')
@section('content')
<div class="col-sm-12">
   <table class="header">
      <tr>
         <td width="50%" nowrap>
            <p><img width="50%" height="50%" id="logo" src="{{ asset(get_option('primary_data',true)->logo ?? '') }}" /></p>
         </td>
         <td width="50%" align="right">
            {{ __('Payment With Razorpay') }}
         </td>
      </tr>
   </table>
</div>

<div class="clear"></div>
<br>
<button class="btn btn-primary mt-4 col-12 w-100 btn-lg" id="rzp-button1">{{ __('Pay Now') }}</button>

   <form action="{{ url('/razorpay/status') }}" method="POST" hidden>
        <input type="hidden" value="{{ csrf_token() }}" name="_token" />
        <input type="text" class="form-control" id="rzp_paymentid" name="rzp_paymentid">
        <input type="text" class="form-control" id="rzp_orderid" name="rzp_orderid">
        <input type="text" class="form-control" id="rzp_signature" name="rzp_signature">
        <button type="submit" id="rzp-paymentresponse" hidden class="btn btn-primary"></button>
    </form>
    <input type="hidden" value="{{ $response['razorpayId'] }}" id="razorpayId">
    <input type="hidden" value="{{ $response['amount'] }}" id="amount">
    <input type="hidden" value="{{ $response['currency'] }}" id="currency">
    <input type="hidden" value="{{ $response['name'] }}" id="name">
    <input type="hidden" value="{{ $response['description'] }}" id="description">
    <input type="hidden" value="{{ $response['orderId'] }}" id="orderId">
    <input type="hidden" value="{{ $response['name'] }}" id="name">
    <input type="hidden" value="{{ $response['email'] }}" id="email">
    <input type="hidden" value="{{ $response['contactNumber'] }}" id="contactNumber">
    <input type="hidden" value="{{ $response['address'] }}" id="address">      
@endsection
@push('js')
<!-- load razorpay payment js api -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script  src="{{ asset('assets/plugins/gateways/razorpay.js') }}"></script>
@endpush