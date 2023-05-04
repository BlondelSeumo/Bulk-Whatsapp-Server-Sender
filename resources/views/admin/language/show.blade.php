@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Edit Language'),
'buttons'=>[
	[
		'name'=>'<i class="fa fa-plus"></i>&nbsp'.__('Add Translation Key'),
		'url'=>'#',
		'components'=>'data-toggle="modal" data-target="#addRecord" id="add_record"',
		'is_button'=>true
	],
	[
	     'name'=> __('Back'),
	     'url'=>route('admin.language.index'),
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
         <form class="ajaxform" action="{{ route('admin.language.update',$id) }}" method="post">
            @csrf
            @method('PUT')
            <!-- Light table -->
            <div class="table-responsive">
               <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                     <tr>
                        <th class="col-6">{{ __('Translation Key') }}</th>
                        <th class="col-6">{{ __('Translated Value') }}</th>
                     </tr>
                  </thead>
                  @foreach($posts ?? [] as $key => $value)
                  <tr>
                     <td>
                        {{ $key }}
                     </td>
                     <td>
                        <input type="text" name="values[{{ $key }}]" class="form-control" value="{{ $value }}">
                     </td>
                  </tr>
                  @endforeach
                  </tbody>
               </table>
            </div>
            <div class="card-footer">
               <button type="submit" class="btn btn-outline-primary submit-button float-right mb-3" >{{ __('Update Changes') }}</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="addRecord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <form method="POST" action="{{ url('admin/language/addkey') }}" class="ajaxform">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">
            <div class="modal-header">
               <h3>{{ __('Add Key') }}</h3>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Key') }}</label>
                  <input type="text" name="key" class="form-control" required>
               </div>
               <div class="form-group">
                  <label>{{ __('Value') }}</label>
                  <input type="text" name="value" class="form-control" required>
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