@extends('gateways.main')
@section('content')
<div class="col-sm-12">
   <table class="header">
      <tr>
         <td width="50%" nowrap>
            <p><img width="50%" height="50%" src="{{ asset(get_option('primary_data',true)->logo ?? '') }}" title="" /></p>
         </td>
         <td width="50%" align="right">
            {{ __('Payment With Stripe') }}
         </td>
      </tr>
   </table>
</div>

<div class="clear"></div>
<br>
<form action="{{ url('stripe/payment') }}" method="post" id="payment-form" class="paymentform p-4">
   @csrf
   <div class="form-row">
      <label for="card-element">
      {{ __('Credit or debit card') }}
      </label>
      <div id="card-element" class="w-100">
         <!-- A Stripe Element will be inserted here. -->
      </div>
      <!-- Used to display form errors. -->
      <div id="card-errors" role="alert"></div>
      <button type="submit" class="btn btn-primary btn-lg w-100 mt-4" id="submit_btn">{{ __('Submit Payment') }}</button>
   </div>
</form>
<input type="hidden" id="publishable_key" value="{{ $Info['publishable_key'] }}">             
@endsection
@push('js')
<!-- load stripe payment js api -->
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/gateways/stripe.js') }}"></script>
@endpush