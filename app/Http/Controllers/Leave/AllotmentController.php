<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employees\EmployeeMast;
use App\Models\Master\LeaveMast;
use App\Models\Employees\LeaveAllotment;
use App\Models\Employees\LeaveApply;

class AllotmentController extends Controller
{
	public function __construct(){
		
		$this->middleware('auth');
	}

	public function index(){

		$allotments = EmployeeMast::with(['allotments'=>function($query){
						$query->with('leaves');
						}])->where('hrms_emp_mast.leave_allotted', '=', 1)
						->whereNull('deleted_at')
						->get();

		return view('leave.allotment.index', compact('allotments'));
	}

	public function create(Request $request){
		
		$employee 	= EmployeeMast::where('user_id', $request->user_id)
						->select('user_id', 'emp_name')
						->first();

		$leaves 	= LeaveMast::orderBy('id', 'asc')->get();
		$sessionStarts	= date('Y-m-d');
		$sessionEnds	= date('Y-m-d', strtotime('Dec 31'));

		return view('HRD.employees.leavesAllot', compact('employee', 'leaves', 'sessionStarts', 'sessionEnds'));
	}

	/******Leaves allot to Employees*********/

    public function store(Request $request){

    	//return $request->all();

    	$exists = LeaveAllotment::where('user_id', $request->user_id)->get();

    	if(count($exists) == 0){

	    	for($i=0; $i<count($request->leave); $i++){

	    		$allotted = new LeaveAllotment;
	    		$allotted->leave_mast_id= $request->leave[$i];
	    		$allotted->user_id		= $request->user_id;
	    		$allotted->start 		= $request->start;
	    		$allotted->end 			= $request->ends;
	    		$allotted->save();
	    	}

	    	$employee = EmployeeMast::where('user_id', $request->user_id)->update([
	    			'leave_allotted' => 1]);		    
	    }

	    return back()->with('success', 'Leave allotted successfully.');
    }

    public function edit( $user_id){

    	$name 		= EmployeeMast::where('user_id', $user_id)
    					->select('user_id', 'emp_name')
    					->first();

		$employee 	= LeaveAllotment::with('leaves')
						->where('user_id', '=', $user_id)
						->get();

    	return view('leave.allotment.edit', compact('name', 'employee'));
    }

    public function update(Request $request,$user_id){

    	$this->validate($request, [
	    	'start'		=>	'required',
	    	'ends'		=>	'required'
    	]);

		$count	= count($request->id);
		$x		= 0;
		$data	= '';

		while($count > $x){

			$data = [
					'start'			=>	$request->start,
					'end'			=>	$request->ends,
					'initial_bal'	=>	$request->leave[$x]
					];

			LeaveAllotment::where('user_id', $user_id)->where('leave_mast_id',$request->id[$x])->update($data);
			$x++;
		}

		return redirect()->route('allotments.index')->with('success', 'Updated successfully.');
    }

    public function destroy( $user_id){

    	LeaveAllotment::where('user_id', $user_id)->delete();

    	EmployeeMast::where('user_id', $user_id)
    		->update(['leave_allotted' => null]);

    	return redirect()->route('allotments.index')->with('success', 'Record deleted successfully.');
    }

    //Hold employee leaves
    public function hold($user_id){

    	LeaveAllotment::where('user_id', $user_id)
    		->update(['status' => 0]);

    	return back()->with('success', 'Leave holded.');
    }

    public function reallot($user_id){

    	LeaveAllotment::where('user_id', $user_id)
    		->update(['status' => 1]);

    	return back()->with('success', 'Leave Re-Allotted.');
    }
}
