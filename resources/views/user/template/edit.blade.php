@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['title'=> 'Edit Template','buttons'=>[
    [
        'name'=>'<i class="fas fa-step-backward"></i> &nbspBack',
        'url'=> route('user.template.index'),
    ]
]])
@endsection
@push('topcss')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')

                  

<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header row">
                <h4 class="text-left col-6">{{ __('Edit Template') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12">
                       @include($component)
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="help-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('Shortcode') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">{{ __('{name} = recipient can see his/her name') }}</li>
          <li class="list-group-item">{{ __('{phone_number} = recipient can see his/her phone number') }}</li>
          <li class="list-group-item">{{ __('{my_name} = recipient can see your name') }}</li>
          <li class="list-group-item">{{ __('{my_email} = recipient can see your email') }}</li>
          <li class="list-group-item">{{ __('{my_contact_number} = recipient can see your contact number') }}</li>
      </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-neutral" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/pages/bulk/template.js') }}"></script>
@endpush