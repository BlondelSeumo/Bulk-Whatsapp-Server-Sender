@extends('layouts.main.app')
@section('head')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css') }}"/>
@endpush
@include('layouts.main.headersection',[
'title'=> __('Customize Menu'),
'buttons'=>[
	[
	'name'=> __('Back'),
	'url'=>route('admin.menu.index'),
	]
 ]
])
@endsection
@section('content')
<div class="row">
	
	<div class="col-lg-8">
		<div class="card mb-3">
			
			<div class="card-body">
				<div class="row mb-10">
					<div class="col-sm-10">
						<h4>{{ __('Menu Items') }}</h4>
					</div>
					<div class="col-sm-2">
						
						<form class="ajaxform" method="post" action="{{ route('admin.menu.content.update',$info->id) }}"> 
							@csrf
							<input type="hidden" name="data" id="data"> <input type="hidden" name="menu_id" value="{{ $info->id }}">
							<button id="form-button" class="btn btn-neutral submit-button float-right" type="submit">
								{{ __('Save') }}
							</button>
						</form>
						
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
					<ul id="myEditor" class="sortableLists list-group">
					</ul>	
				</div>
				</div>
				
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<h4 class="mb-5">{{ __('Create Menu Items') }}</h4>
				<div class="row">
					<div class="col-lg-12">
						<div class="alert alert-danger none">
							<ul id="errors"></ul>
						</div>	
						<form id="frmEdit" class="ajaxform">
							@csrf
							<div class="custom-form">
								<div class="form-group">
									<label for="text">{{ __('Text') }}</label>
									<div class="input-group">
										<input type="text" class="form-control item-menu" name="text" id="text" placeholder="Text" autocomplete="off">
										<div class="input-group-append">
											<button type="button" id="myEditor_icon" class="btn btn-neutral btn-sm"></button>
										</div>
									</div>
									<input type="hidden" name="icon" class="item-menu">
								</div>
								<div class="form-group">
									<label for="href">{{ __('URL') }}</label>
									<input type="text" class="form-control item-menu" id="href" name="href" placeholder="URL" required autocomplete="off">
								</div>
								<div class="form-group">
									<label for="target">{{ __('Target') }}</label>
									<select name="target" id="target" class="form-control mr-sm-2 item-menu">
										<option value="_self">{{ __('Self') }}</option>
										<option value="_blank">{{ __('Blank') }}</option>
										<option value="_top">{{ __('Top') }}</option>
									</select>
								</div>
								<div class="form-group none">
									<label for="title">{{ __('Tooltip') }}</label>
									<input type="text" name="title" class="form-control item-menu" id="title" placeholder="Tooltip">
								</div>
							</div>
						</form>
						<div class="menu-add-update d-flex">
							<button type="button" id="btnUpdate" class="btn btn-update  btn-warning text-white col-6 mr-2" disabled><i class="fas fa-sync-alt"></i> {{ __('Update') }}</button>
							<button type="button" id="btnAdd" class="btn btn-neutral col-6 "><i class="fas fa-plus"></i> {{ __('Add') }}</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<input type="hidden" value="{{ $contents }}" id="menu-data">
@endsection

@push('js')
<script  src="{{ asset('assets/plugins/menu-editor/jquery-menu-editor.min.js') }}"></script>
<script  src="{{ asset('assets/plugins/bootstrap-iconpicker/js/iconset/fontawesome5-3-1.min.js') }}"></script>
<script  src="{{ asset('assets/plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js') }}"></script>
<script  src="{{ asset('assets/plugins/menu-editor/menu.js') }}"></script>
@endpush