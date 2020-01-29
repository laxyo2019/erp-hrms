<?php

namespace App\Http\Controllers\acl;

use DB;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Models\Spatie\ModelRole;
use Spatie\Permission\Models\Permission;
use Models\Spatie\ModelPermission;
use App\Models\Employees\EmployeeMast;

class UserController extends Controller
{

    public function __construct(){

        $this->middleware('auth');
    }

    public function index(){

    	$users = User::all();

    	return view('acl.users.index', compact('users'));
    }

    public function create(Request $request){

    	return view('acl.users.create');
    }

    public function edit( $id){
    	
    	$user          = User::findOrFail($id);
        $employee      = EmployeeMast::where('user_id', $id)->first();
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


    	return view('acl.users.edit', compact('user', 'roles', 'roles_given', 'permissions', 'permissions_given', 'employee'));
    }

    public function update(Request $request, $id){

        $this->validate($request,
                ['name' => 'required']);

        $user       = User::find($id);
        $user->name = $request->name;
        $user->save();

        //Save roles
        $user->syncRoles($request->roles);

        //Save direct permissions to user
        $user->syncPermissions($request->perms);

        return back()->with('success', 'User information updated.');
    }


    public function active(Request $request, $id){

        //set null for activation and timestamp for deactivation in users table and 0(deactivate) or 1(activation) in employee mast.
        
        User::where('id', $id)
                ->update(['deleted_at' => $request->flag]);


        if($request->flag == null){
            $flag = 1;
        }else{
            $flag = 0;
        }

        EmployeeMast::where('user_id', $id)
                ->update(['status' => $flag]);

        
        if($request->flag == null){
            $status = 'activated';
        }else{
            $status = 'dectivated';
        }

        return back()->with('success', 'Employee '.$status.' successfully.');
    }

    //Add as an employee
    
    public function store(Request $request){

        $request->validate([

            'name'      => 'required',
            'email'     => 'required|unique:users',
            'password'  => 'required|confirmed'

        ]);

        $user_id = User::create([
                        'name'     => $request->name,
                        'email'    => $request->email,
                        'password' => bcrypt($request->password)
                    ])->id;

        //return $user_id;
        $employee = new EmployeeMast;
        $employee->emp_name = strtolower($request->name);
        $employee->email    = strtolower($request->email);
        $employee->user_id  = $user_id;
        $employee->save();


        return redirect('acl/users')->with('success', 'User added successfully.');
    }

    //Update users detail and assign role

    public function assign(Request $request){

    $user = User::find( $request->id);

    /**Add user as an employee if not exists**/
        if(empty($user->emp_id)){
            $employee = EmployeeMast::create([
                        'emp_name' => $user->name,
                        'email'    => $user->email ]);

    /*After creating employee take id and update users's emp_id*/
            $user->emp_id = $employee->id;
            $user->save();

        }

        return 'User added as an employee';
    }


    //Delete User (NOT Softdelete)
    
    public function destroy( $id){
        
        User::findOrFail($id)->delete();

        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
}
