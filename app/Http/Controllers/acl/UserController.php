<?php

namespace App\Http\Controllers\acl;

use DB;
use Auth;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Models\Spatie\ModelRole;

use App\Models\Employees\EmployeeMast;

class UserController extends Controller
{

    public function __construct(){

        $this->middleware('auth');
    }

    public function index(){

        $users = User::orderBy('name','ASC')->paginate(100);

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

        #Get all roles
        foreach($user->roles as $index){
            $roles_given[] = $index->id;
        }

        #Get all direct permissions
        $permissions_given = [];
         foreach($user->allPermissions() as $data){
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
        // $roles =  $request->roles;
        // return $roles->toArray();
        //dd($request->roles);

       $user->syncRoles($request->roles);
        //$user->syncRoles($request->roles);

        //Save direct permissions to user
        $user->syncPermissions($request->perms);

        return back()->with('success', 'User information updated.');
    }

    public function active(Request $request, $id){

        //set null for activation and timestamp for deactivation in users table and
        // 0(deactivate) or 1(activation) in employee mast.
        
        User::where('id', $id)
                ->update(['deleted_at' => $request->flag]);

        $date = date("Y-m-d H:i:s", time());
        // return $id;
        $employee = EmployeeMast::withTrashed('deleted_at')->where('user_id','119')->first();
        if($request->flag == null){

            $flag = 1; // true active

            $join_dt = $employee->join_dt !=null ? $employee->join_dt : $date;
            $releave_date = null;
            $rejoin_date = $employee->join_dt !=null ? $date : null;

            $leave_dt = $employee->join_dt !=null ?  $date  : null ;

            $deleted_at = null;
           
        }else{

            $join_dt = $employee->join_dt;
            $releave_date = $employee->leave_dt !=null ? $date : null;
            $rejoin_date = $employee->rejoin_date;
            $leave_dt = $employee->leave_dt !=null ? $employee->leave_dt : $date;

            $flag = 0; //false deactive

            #DeActivate
            $deleted_at = $date;

        }
        // return $deleted_at;


        EmployeeMast::withTrashed('deleted_at')->where('user_id', $id)
                ->update([
                    'status'        => $flag,
                    'releave_date'  => $releave_date,
                    'rejoin_date'   => $rejoin_date,
                    'join_dt'       => $join_dt,
                    'leave_dt'      => $leave_dt,
                    'deleted_at'    => $deleted_at
                ]);

        
        if($request->flag == null){
            $status = 'activated';
        }else{
            $status = 'dectivated';
        }

        return back()->with('success', 'Employee has been '.$status);
    
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
        $employee->emp_name      = strtolower($request->name);
        $employee->comp_email    = strtolower($request->email);
        $employee->user_id       = $user_id;
        $employee->save();


        return redirect('acl/users')->with('success', 'User added successfully.');
    }

    //Update users detail and assign role

    public function assign(Request $request){

    $emp = EmployeeMast::where('user_id',$request->id)->first();
    $user = User::find($request->id); 
    /**Add user as an employee if not exists**/
        if(empty($emp)){
            $employee = EmployeeMast::create([
                        'emp_name' => $user->name,
                        'comp_email'    => $user->email,
                        'user_id'   => $user->id
                    ]);
            return response()->json('User added as an employee',200);
        }
        else{
         return response()->json('User already an employee',201);   
        }
    }


    //Delete User (NOT Softdelete)
    
    public function destroy( $id){
        
        User::findOrFail($id)->delete();

        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
}
