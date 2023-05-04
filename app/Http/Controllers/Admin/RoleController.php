<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct(){
         $this->middleware('permission:roles'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $roles = Role::where('id','!=',1)->get();
        return view('admin.role.index', compact('roles'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $permisions = Permission::all();
        $permission_groups = User::getPermissionGroup();
        return view('admin.role.create', compact('permisions', 'permission_groups'));
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:roles|max:100',
        ]);
        $role = Role::create(['name' => $request->name]);
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {

            $role->syncPermissions($permissions);
        }

        return response()->json(['message'=> __('Role created successfully')]);
    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $role = Role::findById($id);
        $all_permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.role.edit', compact('role', 'all_permissions', 'permission_groups'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles,name,' . $id
        ], [
            'name.requried' => 'Please give a role name'
        ]);

        $role = Role::findById($id);
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return response()->json(['message' => __('Role has been updated !!')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Role::destroy($id);
        return response()->json([
            'redirect' => route('admin.role.index'),
            'message'=> __('Role Removed')
        ]);
        
    }
}
