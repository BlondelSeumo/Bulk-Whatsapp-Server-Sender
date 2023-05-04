@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title' => __('Contact List'),
'buttons' =>[
	[
		'name'=>__('Create Contact'),
		'url'=> route('user.contact.create'),
	],
	[
		'name'=>__('Sent Bulk With Template'),
		'url'=>'#',
		'components'=>'data-toggle="modal" data-target="#send-template-bulk" id="send-template-bulks"',
		'is_button'=>true
	]
]])
@endsection
@push('topcss')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">

@endpush
@section('content')
<div class="row justify-content-center">
	<div class="col-12">
		<div class="row d-flex justify-content-between flex-wrap">
			<div class="col">
				<div class="card card-stats">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<span class="h2 font-weight-bold mb-0 total-transfers" id="total-device">
									{{ $total_contacts }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-address-book mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Contacts') }}</h5>
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
								  {{ $limit }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fas fa-signal"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Contacts statics') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
			
		</div>

		@if(count($contacts ?? []) > 0)
		<div class="card">
			
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<table class="table col-12">
							<thead>
								<tr>
									<th class="col-3">{{ __('Contact Name') }}</th>
									<th class="col-7 text-right">{{ __('Whatsapp Number') }}</th>
									
									<th class="col-2 text-right">{{ __('Action') }}</th>
								</tr>
							</thead>
							<tbody class="tbody">
								@foreach($contacts ?? [] as $contact)
								<tr>
									<td>
										{{ $contact->name }}
									</td>
									<td class="text-right">
										{{ $contact->phone }}
									</td>									
									<td>
										<div class="btn-group mb-2 float-right">
											<button class="btn btn-neutral btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												{{ __('Action') }}
											</button>
											<div class="dropdown-menu">
												<a class="dropdown-item has-icon edit-contact" href="#" 
												data-action="{{ route('user.contact.update',$contact->id) }}" 
												data-name="{{ $contact->name }}"  
												data-phone="{{ $contact->phone }}"
												data-toggle="modal" 
												data-target="#editModal"
												>
												<i class="ni ni-align-left-2"></i>{{ __('Edit') }}</a>
												<a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-action="{{ route('user.contact.destroy',$contact->id) }}"><i class="fas fa-trash"></i>{{ __('Remove Number') }}</a>
											</div>
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<div class="d-flex justify-content-center">{{ $contacts->links('vendor.pagination.bootstrap-4') }}</div>
					</div>
				</div>
			</div>
		</div>
		@else
		<div class="alert  bg-gradient-primary text-white"><span class="text-left">{{ __('Opps There Is No Contact Found....') }}</span></div>
		@endif
	</div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form type="POST" action="" class="edit-modal ajaxform_instant_reload">
				@csrf
				@method('PUT')

				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Contact') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>{{ __('User Name') }}</label>
						<input type="text" name="name" id="user_name" placeholder="Jhone Doe" maxlength="50" class="form-control" required="">
					</div>
					<div class="form-group">
						<label>{{ __('Whatsapp Number') }}</label>
						<input type="number" name="phone" id="user_phone" placeholder="{{ __('Enter Phone Number With Country Code') }}" maxlength="15" class="form-control">
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
					<button type="submit" class="btn btn-primary submit-btn">{{ __('Save changes') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="send-template-bulk" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
	<div class="modal-dialog">
		@if(count($templates) > 0 && count($contacts) > 0)
		<div class="modal-content">
			
			<form type="POST" action="{{ route('user.contact.send-template-bulk') }}" class="ajaxform bulk_send_form">
				@csrf
				<input type="hidden" name="page_url" value="{{ url()->full() }}">
				
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{ __('Send Bulk Message With Template') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					
					<div class="form-group">
						<label>{{ __('Select Template') }}</label>
						<select  class="form-control" name="template">
							@foreach($templates as $template)
								<option value="{{ $template->id }}">{{ $template->title }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>{{ __('Select Device') }}</label>
						<select  class="form-control" name="device">
							@foreach($devices as $device)
								<option value="{{ $device->id }}">{{ $device->name }} - {{ $device->phone }}</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group receivers">
						<label>{{ __('Select Receivers') }}</label>
						<select  class="form-control select2" name="contacts[]" multiple="">
							@foreach($contacts as $conatct)
								<option value="{{ $conatct->id }}">({{ $conatct->name }}) - {{ $conatct->phone }}</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group d-flex">
						<label class="custom-toggle custom-toggle-primary">
							<input type="checkbox"  name="sentall" id="plain-text"  data-target=".plain-title" class="save-template">
							<span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
						</label>
						<label class="mt-1 ml-1" for="plain-text"><h4>{{ __('Sent this template to all user?') }}</h4></label>
					</div>
					

				</div>

				<div class="modal-footer">
					
					<button type="submit" class="btn btn-neutral submit-btn float-right">{{ __('Sent Now') }}</button>
				</div>
			</form>
		</div>
		@else
		<div class="alert  bg-gradient-primary text-white"><span class="text-left">{{ __('Create some template and contacts') }}</span></div>
		@endif
	</div>
</div>
@endsection
@push('topjs')
<script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
@endpush
@push('js')
<script src="{{ asset('assets/js/pages/user/contact.js') }}"></script>
@endpush
