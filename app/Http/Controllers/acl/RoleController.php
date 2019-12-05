<?php

namespace App\Http\Controllers\acl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role ;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(){

    	$roles	= Role::all();
    	return view('acl.roles.index', compact('roles'));
    }

    public function create(){

        //return Role::find(1)->getDirectPermissions();

    	$permissions = Permission::all();
        //return $permission;

    	return view('acl.roles.create', compact('permissions'));
    }

    public function store(Request $request){
        
        $this->validate($request, [
    		'role' => 'required'
    	]);

        $role = Role::create(['name' => $request->role]);
        $role->syncPermissions($request->permissions);
    	return redirect()->route('roles.index')->with('success', 'Roles added successfully.');
    }

    public function edit( $id){
    	$role        = Role::findOrFail($id);
        $permissions = Permission::all();

        $permission_given = [];

        foreach($role->permissions as $perms){
            $permission_given[] = $perms->id;
        }
    	return view('acl.roles.edit', compact('role', 'permissions', 'permission_given'));
    }

    public function update(Request $request, $id){

        $this->validate($request,
                ['name' => $request->role]);

        Role::where('id', $id)
                ->update(['name' => $request->role]);

        //dd($user->hasPermissionTo(Permission::find(1)->id));

        $role = Role::find( $id);
        $role->syncPermissions($request->perms);


        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy( $id){

    	Role::findOrFail($id)->delete();
    	return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
