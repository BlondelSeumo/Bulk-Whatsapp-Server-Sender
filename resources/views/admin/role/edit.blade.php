@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Edit Role'),
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
         <form method="post" action="{{ route('admin.role.update',$role->id) }}" class="ajaxform">
            @csrf
            @method("PUT")
            <div class="pt-20">
               <div class="form-group">
                  <label>{{ __('Role Name') }}</label>
                  <input type="text" class="form-control" required="" value="{{ $role->name }}"  name="name" placeholder="sub admin">
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
                              @php
                              $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                              $j = 1;
                              @endphp
                              <div class="col-6">
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" 
                                    class="custom-control-input" id="{{ $i }}Management" 
                                    value="{{ $group->name }}" 
                                    onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" 
                                    {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="checkPermission">{{ $group->name }}</label>
                                 </div>
                              </div>
                              <div class="col-6 role-{{ $i }}-management-checkbox">
                                 @foreach ($permissions as $permission)
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" 
                                    
                                    onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})" 
                                    name="permissions[]" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} 

                                    id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}"

                                    >
                                    <label class="custom-control-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                 </div>
                                 @php  $j++; @endphp
                                 @endforeach
                                 <br>
                              </div>
                           </div>
                           @php  $i++; @endphp
                        </div>
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