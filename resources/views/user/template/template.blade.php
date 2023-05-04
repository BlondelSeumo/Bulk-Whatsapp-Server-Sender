@extends('layouts.main.app')
@push('topcss')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
@endpush
@section('head')
@include('layouts.main.headersection',['buttons'=>[
   [
      'name'=>'<i class="fa fa-plus"></i>&nbsp'. __('Add Record'),
      'url'=>'#',
      'components'=>'data-toggle="modal" data-target="#addRecord" id="add_record"',
      'is_button'=>true
   ],
   [
      'name'=>'<i class="fa fa-plus"></i>&nbsp'. __('Contact List'),
      'url'=>'#',
      'components'=>'data-toggle="modal" data-target="#import-from-contact" id="import_from_contact"',
      'is_button'=>true
   ],
   [
      'name'=>'<i class="fa fa-file-csv"></i>&nbsp'. __('Import Contacts From CSV'),
      'url'=>'#',
      'components'=>'data-toggle="modal" data-target="#exampleModal" id="import_record"',
      'is_button'=>true
   ],
   [
      'name'=>'<i class="fa fa-clipboard-list"></i>&nbsp'. __('Messages Log'),
      'url'=>url('/user/bulk-message'),
      'is_button'=>false
   ]
]])
@endsection
@section('content')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-body">
            <div class="form-group">
               <label>{{ __('Select Number (From)') }}</label>
               <select class="form-control" id="device_import"  name="device" required="">
                  <option value="" disabled="" selected="">{{ __('Select Number') }}</option>
                  @foreach($devices as $device)
                  <option value="{{ $device->id }}">{{ $device->name }} (+{{ $device->phone }})</option>
                  @endforeach
               </select>
            </div>
            <div class="form-group none csv_row">
               <label>{{ __('Select CSV File') }} <a href="{{ asset('uploads/demo.csv') }}" download="" class="text-primary">({{ __('Download Sample') }})</a></label>
               <input type="file" name="csv" class="form-control csv" required="" accept=".csv">
            </div>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary col-12" data-dismiss="modal">{{ __('Close') }}</button>
         </div>   
      </div>
   </div>
</div>
<div class="modal fade" id="import-from-contact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-body">
            <div class="form-group">
               <label>{{ __('Select Number (From)') }}</label>
               <select class="form-control" id="device_import"  name="device" required="">
                  <option value="" disabled="" selected="">{{ __('Select Number') }}</option>
                  @foreach($devices as $device)
                  <option value="{{ $device->id }}">{{ $device->name }} (+{{ $device->phone }})</option>
                  @endforeach
               </select>
            </div>
            <div class="form-group">
               <label>{{ __('Select Receivers') }}</label>
               <select class="form-control select2" id="contacts"  name="contacts[]"  required="" data-toggle="select" multiple="">
                  @foreach($contacts ?? [] as $contact)
                  <option value="{{ $contact->id }}" data-contact>{{ $contact->name }} (+{{ $contact->phone }})</option>
                  @endforeach
               </select>
            </div>
            <div class="form-group">
               <label>{{ __('Message') }}</label>
               <textarea class="form-control" required="" id="wa_message" maxlength="1000"></textarea>
               <span class="text-danger message_alert none">{{ __('Add The Message') }}</span>
            </div>

         </div>
         <div class="modal-footer">

            <button type="button" class="btn btn-outline-primary col-12" data-dismiss="modal">{{ __('Close') }}</button>
            
         </div>   
      </div>
   </div>
</div>

<div class="modal fade" id="addRecord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4>{{ __('Add Custom Row') }}</h4>
         </div>   
         <div class="modal-body">
            <div class="form-group">
               <label>{{ __('Select Number (From)') }}</label>
               <select class="form-control" id="device_custom"  name="device" required="">
                  @foreach($devices as $device)
                  <option value="{{ $device->id }}">+{{ $device->phone }}</option>
                  @endforeach
               </select>
            </div>
            <div class="form-group">
               <label>{{ __('Receiver (To)') }}</label>
               <input type="number" class="form-control" required="" id="to" placeholder="{{ __('Enter mobile number with country code') }}">
               <span class="text-danger to_alert none">{{ __('Add The Whatsapp Number') }}</span>
            </div>
            <div class="form-group">
               <label>{{ __('Message') }}</label>
               <textarea class="form-control" required="" id="wa_message" maxlength="1000"></textarea>
               <span class="text-danger message_alert none">{{ __('Add The Message') }}</span>
            </div>
         </div>
         <div class="modal-header">
            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">{{ __('Close') }}</button>
            <button class="btn btn-outline-primary add_custom_row" type="submit">{{ __('Add Now') }}</button>
         </div>   
      </div>
   </div>
</div>

<div class="row justify-content-center">
   <div class="col-12">
      <div class="card">
         
         <div class="card-body">
            <div class="row mb-3">
               <div class="col-12">
                  <div class="float-left">
                     <h4><span class="total_sent">0</span>/<span class="total_records">0</span></h4>
                  </div>

                  <div class="float-right">
                     <button class="btn  btn-neutral btn-sm  send_now" type="button"><i class="ni ni-send"></i>&nbsp&nbsp{{ __('Send Now') }}</button>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-12 table-responsive">
                  <table class="table col-12">
                     <thead>
                        <tr>
                           <th class="col-3">{{ __('Receiver (To)') }}</th>
                           <th class="col-2">{{ __('Device (From)') }}</th>
                           <th class="col-7">{{ __('Message') }}</th>
                           <th class="col-2">{{ __('Status') }}</th>
                        </tr>
                     </thead>
                     <tbody class="tbody">
                        
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>



<input type="hidden" id="base_url" value="{{ url('/') }}">
<input type="hidden" id="bulk_message_link" value="{{ route('user.bulk-message.store') }}">
@csrf
@endsection
@push('js')
<script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/bulk/jquery.csv.min.js') }}" ></script>
<script src="{{ asset('assets/js/pages/bulk/bulkmessage.js') }}" ></script>
@endpush