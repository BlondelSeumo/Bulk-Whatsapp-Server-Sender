@extends('gateways.main')
@section('content')
<div class="col-sm-12">
   <table class="header">
      <tr>
         <td width="50%" nowrap>
            <p><img width="50%" height="50%" src="{{ asset(get_option('primary_data',true)->logo ?? '') }}" title="" /></p>
         </td>
         <td width="50%" align="right">
            {{ __('Payment With PayU') }}
         </td>
      </tr>
   </table>
</div>

<div class="clear"></div>
<br>
<form action="#" method="post" name="payuForm" id="payment_form">
 @csrf
 <input type="hidden" id="udf5" name="udf5" value="BOLT_KIT_PHP7" />
 <input type="hidden" id="salt" value="{{ $Info['salt'] }}" />
 <input type="hidden" name="key" id="key" value="{{ $Info['key'] }}" />
 <input type="hidden" name="hash" id="hash" value="{{ $Info['hash'] }}" />
 <input type="hidden" name="txnid" id="txnid" value="{{ $Info['txnid'] }}" />
 <input type="hidden" name="amount" id="amount" value="{{ $Info['amount'] }}" />
 <input type="hidden" name="firstname" id="firstname" value="{{ $Info['firstname'] }}" />
 <input type="hidden" name="email" id="email" value="{{ $Info['email'] }}" />
 <input type="hidden" name="phone" id="mobile" value="{{ $Info['phone'] }}" />
 <input type="hidden" name="productinfo" id="productinfo" value="{{ $Info['productinfo'] }}" />
 <input type="hidden" name="surl" id="surl" value="{{ $Info['surl'] }}" />
 <input type="hidden" name="furl" id="furl" value="{{ $Info['furl'] }}" />
 <div class="card-footer bg-white">
   <input type="submit" class="btn btn-primary mt-4 col-12 w-100 btn-lg" value="Pay Now"/>
</div>
</form>

          
@endsection
@push('js')
<!-- load payu payment js api -->
@if ($Info['test_mode'] == true)
<script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js" bolt- color="e34524"
bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>
@else
<script id="bolt" src="https://checkout-static.citruspay.com/bolt/run/bolt.min.js" bolt-color="e34524"
bolt-logo="http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png"></script>
@endif

<script type="text/javascript" src="{{ asset('assets/plugins/gateways/payu.js') }}"></script>
@endpush