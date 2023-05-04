@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Create Role'),
'buttons'=>[
   [
      'name'=> __('Back'),
      'url'=> route('admin.role.index')
   ]
]
])
@endsection
@section('content')
<div class="row">
<div class="col-lg-12">
   <div class="card">
      <div class="card-header">
         <h4>{{ __('Add Role') }}</h4>
      </div>
      <div class="card-body">
         <form method="post" action="{{ route('admin.role.store') }}" class="ajaxform_reset_form">
            @csrf
            <div class="pt-20">
               <div class="form-group">
                  <label>{{ __('Role Name') }}</label>
                  <input type="text" class="form-control" required="" name="name" placeholder="sub admin">
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkAll" id="customCheck12">
                        <label class="custom-control-label checkAll" for="customCheck12">{{ __('Check All Permissions') }}</label>
                     </div>
                     <hr>
                     @php $i = 1; @endphp
                     <div class="row">
                        @foreach ($permission_groups as $group)
                        <div class="col-sm-6">
                           <div class="row">
                              <div class="col-3">
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input group-input" id="{{ $i }}Management" value="{{ $group->group_name }}" data-class="role-{{ $i }}-management-checkbox">
                                    <label class="custom-control-label" for="{{ $i }}Management">{{ $group->group_name }}</label>
                                 </div>
                              </div>
                              <div class="col-9 role-{{ $i }}-management-checkbox">
                                 @php
                                 $permissions = \App\Models\User::getpermissionsByGroupName($group->group_name);
                                 $j = 1;
                                 @endphp
                                 @foreach ($permissions as $permission)
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="permissions[]" id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                    <label class="custom-control-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                 </div>
                                 @php  $j++; @endphp
                                 @endforeach
                                 <br>
                              </div>
                           </div>
                        </div>
                        @php  $i++; @endphp
                        @endforeach	
                     </div>
                  </div>
               </div>
            </div>
      </div>
      <div class="card-footer">
      <button type="submit" class="btn btn-neutral submit-button"><i class="fa fa-save"></i> {{ __('Save') }}</button>
      </div>
   </div>
</div>
</form>
@endsection