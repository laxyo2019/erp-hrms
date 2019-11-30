<?php

namespace App\Http\Controllers\acl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Models\Spatie\ModelRole;
use Spatie\Permission\Models\Permission;
use Models\Spatie\ModelPermission;
use DB;
use App\User;
use Auth;
use App\Models\Employees\EmployeeMast;

// test
class UserController extends Controller
{
    public function index(){
    	$users = User::all();
        //return $users;
    	return view('acl.users.index', compact('users'));
    }

    public function create( $id){
    	$user = User::find($id);
    	$roles = Role::all();

    	return view('acl.users.create', compact('user', 'roles'));
    }

    public function store(Request $request, $id){

    	$this->validate($request, [
    		'role' => 'required']);

    	$user = User::find( $id);
    	$role_name = Role::find($request->role)->name;

    	$user->assignRole($role_name);
    	return redirect()->route('users.index')->with('success', 'Role Assigned successfully');
    }

    public function edit( $id){
    	
    	$user          = User::find( $id);
    	$roles         = Role::all();
        $permissions   = Permission::all();

        $roles_given = [];

        //Get all roles
        foreach($user->roles as $index){
            $roles_given[] = $index->id;
        }

        //Get all direct permissions
        $permissions_given = [];
        foreach($user->getDirectPermissions() as $data){
            $permissions_given[] = $data->id;
        }

    	/*
    	return ([$user, $role, $roles]);
    	return $role['pivot']->role_id;
        $role   = $user->roles()->first();
		return User::role('team lead')->get();
    	return $user->assignRole('Team Lead');
    	foreach($per as $id){
    		$permissionId[] = $id->id;
    	}
    	return $permissionId;
    	return $permission[2]->id;
    	*/

    	return view('acl.users.edit', compact('user', 'roles', 'roles_given', 'permissions', 'permissions_given'));
    }

    public function update(Request $request, $id){

        //return 54;
        $this->validate($request,
                ['name' => 'required']);

        $user = User::find($id);

        $user->name = $request->name;
        $user->save();

        //Save roles
        $user->syncRoles($request->roles);
        //Save direct permissions to user
        $user->syncPermissions($request->perms);

        //Add user as an employee if not exists
        if(empty($user->emp_id)){
            $user_id = EmployeeMast::create([
                        'emp_name'  => $user->name])->id;
            $user->emp_id = $user_id;
            $user->save();

            return redirect()->route('users.index')->with('success', 'User Added as an Employee.');
        }else{
            return redirect()->route('users.index')->with('success', 'User already Added.');
        }


    return back()->with('success', 'User information updated.');
    }

    public function destroy( $id){
        
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    public function AssignUser($id){
        
        $user = User::findOrFail( $id);
        
        //Add user as an employee if not exists
        if(empty($user->emp_id)){ 
            $user_id = EmployeeMast::create([
                        'emp_name'  => $user->name])->id;

            $user->emp_id = $user_id;
            $user->save();

            return redirect()->route('users.index')->with('success', 'User added as an Employee.');
        }else{
            return redirect()->route('users.index')->with('success', 'User already Added.');
        }

    }
}
