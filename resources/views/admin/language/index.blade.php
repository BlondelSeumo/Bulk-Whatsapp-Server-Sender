@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Languages'),
'buttons'=>[
   [
      'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create a language'),
      'url'=>'#',
      'components'=>'data-toggle="modal" data-target="#addRecord" id="add_record"',
      'is_button'=>true
   ]
]

])
@endsection
@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<!-- Card header -->
			<div class="card-header border-0">
				<h3 class="mb-0">{{ __('Languages') }}</h3>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th class="col-2">{{ __('Language Name') }}</th>
							<th class="col-2">{{ __('Language Key') }}</th>
							<th class="col-8 text-right">{{ __('Action') }}</th>
						</tr>
					</thead>					
						@foreach($languages ?? [] as $languageKey => $language)
						<tr>
							<td class="text-left">
								{{ $language }}
							</td>
							<td class="text-left">
								{{ $languageKey }}
							</td>
							<td class="text-right">
								<a href="{{ route('admin.language.show',$languageKey) }}" class="btn btn-neutral btn-sm"><i class="fas fa-edit"></i></a>
								<a href="#" class="delete-confirm btn btn-sm btn-neutral" data-action="{{ route('admin.language.destroy',$languageKey) }}"><i class="fas fa-trash"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>				
			</div>			
		</div>
	</div>
</div>
<div class="modal fade" id="addRecord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="{{ route('admin.language.store') }}" class="ajaxform_reset_form">
            @csrf
            <div class="modal-header">
               <h3>{{ __('Create Language') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Language Name') }}</label>
                  <input type="text" name="name" class="form-control" required="" placeholder="English">
               </div>
               <div class="form-group">
                  <label>{{ __('Select Language') }}</label>
                  <select class="form-control select2" name="language_code">
                  	@foreach($countries as $country)
                  	<option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                  	@endforeach
                  </select>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-outline-primary col-12 submit-button" >{{ __('Create Now') }}</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection