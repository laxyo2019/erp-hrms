<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Employees\EmployeeMast;

class InformationController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(){

    	$info = EmployeeMast::where('id', Auth::user()->emp_id)->with('department')->first();

    	return view('information.index', compact('info'));

    }

    public function edit( $id){
    	
    	$info = EmployeeMast::findOrFail(Auth::user()->emp_id);

    	return view('information.edit', compact('info'));
    }

    public function update(Request $request, $id){

    	if($id == Auth::user()->emp_id){

    		EmployeeMast::where('id', $id)
    			->update([
					'emp_name'      => $request->emp_name,
                    'emp_gender'    => $request->emp_gender, 
					'emp_dob'       => $request->dob,
					'contact'       => $request->contact,
					'email'	        => $request->email,
					'curr_addr'     => $request->address]);

    		return redirect()->route('information.index')->with('success', 'Successfully updated.');

    	}else{

    		return view('information.index')->with('failure', 'You are not authorized to do this.');

    	}
    }
}
