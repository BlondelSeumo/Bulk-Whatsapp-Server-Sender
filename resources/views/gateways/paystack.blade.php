@extends('gateways.main')
@section('content')
<div class="col-sm-12">
   <table class="header">
      <tr>
         <td width="50%" nowrap>
            <p><img width="50%" height="50%" src="{{ asset(get_option('primary_data',true)->logo ?? '') }}" title="" /></p>
         </td>
         <td width="50%" align="right">
            {{ __('Payment With Paystack') }}
         </td>
      </tr>
   </table>
</div>

<div class="clear"></div>
<br>
<button class="btn btn-primary mt-4 col-12 w-100 btn-lg" id="payment_btn">{{ __('Pay Now') }}</button>

<form method="post" class="status" action="{{ route('paystack.status') }}">
 @csrf
 <input type="hidden" name="ref_id" id="ref_id">
 <input type="hidden" value="{{ $Info['currency'] }}" id="currency">
 <input type="hidden" value="{{ $Info['amount'] }}" id="amount">
 <input type="hidden" value="{{ $Info['public_key'] }}" id="public_key">
 <input type="hidden" value="{{ $Info['email'] ?? Auth::user()->email }}" id="email">
</form>

<input type="hidden" id="pay-id" value="{{ 'ps_'.Str::random(15) }}">          
@endsection
@push('js')
<!-- load paystack payment js api -->
<script src="https://js.paystack.co/v1/inline.js"></script>
<script  src="{{ asset('assets/plugins/gateways/paystack.js') }}"></script>
@endpush