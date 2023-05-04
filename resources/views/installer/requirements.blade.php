@extends('installer.app')
@section('content')
@php
$enabled=true;
@endphp
<div class="col-sm-12">
   <h3 class="text-center">🎉 {{ __('Welcome to WASender Web Installer') }}</h3>
   <table class="header table table-hover mt-3">
    <tr>
      <th>{{ __('Extension') }}</th>
      <th class="text-right">{{ __('Status') }}</th>
    </tr>
      <tr>
         <td><h4>{{ __('PHP >= 8.1') }}</h4></td>
         <td class="text-right">
           <i class="fas {{ PHP_VERSION >= 8.1 ? 'fas fa-check text-success' : 'fas fa-times text-danger'  }}"></i> 
        </td>
     </tr>
     @foreach($extentions as $key =>  $extention)
     @php
     $extention != true ? $enabled = false : '';
     @endphp
     <tr>
      <td><h4>{{ $key }}</h4></td>
      <td class="text-right">
        <i class="fas {{ $extention == 1 ? 'fas fa-check text-success' : 'fas fa-times text-danger'  }}"></i> 
     </td>
  </tr>
  @endforeach
</table>

<h3 class="col-8 float-left mt-3 {{ $enabled == true ? 'text-dark'  : 'text-danger' }}">
{{ $enabled == true ? __('Click to next button')  : __('Some extensions are missing') }}
</h3>
<a href="{{ $enabled == true ? url('/install/purchase') : 'javascript:void(0)' }}" class="btn btn-outline-primary col-4 float-right mt-3">
 @if($enabled == false) <del> @endif
   <span class="mb-1">{{ __('Next') }}</span> 
   <i class="fi  fi-rs-angle-right text-right mt-5"></i> 
@if($enabled == false) </del> @endif
</a>
</div>

<div class="clear"></div>
<br>        
@endsection
