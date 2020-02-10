<?php

namespace App\Http\Controllers\acl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master\DeptMast;
use App\Models\Employees\EmployeeMast;
use App\Models\Master\ActivityMast;
use App\Models\Master\Designation;
use Spatie\Permission\Models\Role ;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

    public function index(){

    	$permissions = Permission::all();

    	return view('acl.permissions.index', compact('permissions'));
    }

    public function create(){

    	return view('acl.permissions.create');
    }

    public function store(Request $request){

    	$this->validate($request, [
    		'permission'      => 'required'
    		]);

    	$permission = Permission::create(['name' => $request->permission]);

    	return redirect()->route('permissions.index')->with('success', 'Permission Created.');
    }

    public function edit( $id){
    	$permission = Permission::where('id', $id)->first();

    	return view('acl.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id){

    	$this->validate($request, [
    		'permission'        => 'required'
    		]);

    	$permission = Permission::where('id', $id)
    			         ->update(['name' =>  $request->permission]);


        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');

    }

    public function destroy( $id){
    	
    	Permission::findOrFail($id)->delete();
    	return redirect()->route('permissions.index')->with('success', 'Permission deleted.');
    }
}
