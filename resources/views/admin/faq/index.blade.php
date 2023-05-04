@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Frequently asked questions'),
'buttons'=>[
   [
      'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Create FAQ'),
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
				<h3 class="mb-0">{{ __('FAQS') }}</h3>
			</div>
			<!-- Light table -->
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th class="col-3">{{ __('Question') }}</th>
							<th class="col-6">{{ __('Answer') }}</th>
							<th class="col-1 text-right">{{ __('Language') }}</th>
							<th class="col-1 text-right">{{ __('Action') }}</th>
						</tr>
					</thead>					
						@foreach($faqs ?? [] as  $faq)
						<tr>
							<td class="text-left">
								{{ Str::limit($faq->title,30) }}
							</td>
							<td class="text-left">
								{{ Str::limit($faq->excerpt->value ?? '',70) }}
							</td>
							<td class="text-right">
								{{ $faq->lang }}
							</td>
							<td class="text-right">
								<div class="btn-group mb-2 float-right">
									<button class="btn btn-neutral btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										{{ __('Action') }}
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item has-icon edit-row" href="#" 
										data-action="{{ route('admin.faq.update',$faq->id) }}" 
										data-question="{{ $faq->title ?? '' }}"
										data-answer="{{ $faq->excerpt->value ?? '' }}"  
										data-lang="{{ $faq->lang }}"
										data-position="{{ $faq->slug }}"
										data-toggle="modal" 
										data-target="#editModal"
										>
										<i class="fi fi-rs-edit"></i>{{ __('Edit') }}</a>

										
										<a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-action="{{ route('admin.faq.destroy',$faq->id) }}"><i class="fas fa-trash"></i>{{ __('Remove faq') }}</a>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>				
			</div>

			<div class="card-footer py-4">
				{{ $faqs->links('vendor.pagination.bootstrap-5') }}
			</div>					
		</div>
	</div>
</div>




<div class="modal fade" id="addRecord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="{{ route('admin.faq.store') }}" class="ajaxform_instant_reload">
            @csrf
            <div class="modal-header">
               <h3>{{ __('Create FAQ') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Question') }}</label>
                  <input type="text" name="question" maxlength="150" class="form-control" required="">
               </div>
               <div class="form-group">
                  <label>{{ __('Answer') }}</label>
                 <textarea class="form-control h-100" maxlength="500" name="answer" required=""></textarea>
               </div>
               
               <div class="form-group">
                  <label>{{ __('Select position') }}</label>
                 <select class="form-control" name="position"  required="">                 	
                 	<option value="top">{{ __('For App Question') }}</option>
                 	<option value="bottom" selected="">{{ __('Regular') }}</option>                 
                 </select>
               </div>
               <div class="form-group">
                  <label>{{ __('Select Language') }}</label>
                 <select class="form-control" name="language" required="">
                 	@foreach($languages as $languageKey => $language)
                 	<option value="{{ $languageKey }}">{{ $language }}</option>
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

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="" class="ajaxform_instant_reload edit-modal">
            @csrf
            @method("PUT")

            <div class="modal-header">
               <h3>{{ __('Edit FAQ') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Question') }}</label>
                  <input type="text" name="question" maxlength="150" class="form-control" id="question" required="">
               </div>
               <div class="form-group">
                  <label>{{ __('Answer') }}</label>
                 <textarea class="form-control h-100" maxlength="500" name="answer" required="" id="answer"></textarea>
               </div>
               
                <div class="form-group">
                  <label>{{ __('Select position') }}</label>
                 <select class="form-control" name="position" id="position" required=""> 
                 	<option value="top">{{ __('For App Question') }}</option>
                 	<option value="bottom">{{ __('Bottom') }}</option>                
                 </select>
               </div>
               <div class="form-group">
                  <label>{{ __('Select Language') }}</label>
                 <select class="form-control" name="language" id="language" required="">
                 	@foreach($languages as $languageKey => $language)
                 	<option value="{{ $languageKey }}">{{ $language }}</option>
                 	@endforeach
                 </select>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-outline-primary col-12 submit-button" >{{ __('Update') }}</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/js/pages/admin/faq.js') }}"></script>
@endpush