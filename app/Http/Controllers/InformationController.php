<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\Employees\EmployeeMast;

class InformationController extends Controller
{
    public function __construct(){
        
    	$this->middleware('auth');
    }

    public function index(){

        $user = Auth::id();

    	$info = EmployeeMast::where('user_id', Auth::id())->with('department')->first();

    	return view('information.index', compact('info'));

    }

    public function edit( $id){
    	
    	$info = EmployeeMast::where('user_id', Auth::id())->first();

    	return view('information.edit', compact('info'));
    }

    public function update(Request $request, $id){

        //return ([$request->all(), $id]);

        $request->validate([
            'emp_name'  => 'required',
            'email'     => 'required' ]);


    	if($id == Auth::id()){

    		EmployeeMast::where('user_id', $id)
    			->update([
					'emp_name'      => $request->emp_name,
                    'emp_gender'    => $request->emp_gender, 
					'emp_dob'       => $request->dob,
					'contact'       => $request->contact,
					'email'	        => $request->email,
					'curr_addr'     => $request->address]);

            User::find($id)->update([
                'name' => $request->emp_name,
                'email'=> $request->email
            ]);

    		return redirect()->route('information.index')->with('success', 'Successfully updated.');

    	}else{

    		return view('information.index')->with('failure', 'You are not authorized to do this.');

    	}
    }
}
