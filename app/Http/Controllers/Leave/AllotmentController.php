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

	public function index(){

		$allotments = EmployeeMast::with(['allotments'=>function($query){
							$query->with('leaves');
							}])->where('emp_mast.leave_allotted', '=', 1)
							->whereNull('deleted_at')
							->get();
	
		return view('leave.allotment.index', compact('allotments'));
	}

	public function create(Request $request){
		
		$employee 	= EmployeeMast::where('id', $request->emp_id)
						->select('id', 'emp_name')
						->first();

		$leaves 	= LeaveMast::all();
		$sessionStarts	= date('Y-m-d');
		$sessionEnds	= date('Y-m-d', strtotime('Dec 31'));

		return view('HRD.employees.leavesAllot', compact('employee', 'leaves', 'sessionStarts', 'sessionEnds'));
	}

	/******Leaves allot to Employees*********/

    public function store(Request $request){

    	//return $request->leave[0];
    	$exists = LeaveAllotment::where('emp_id', $request->emp_id)->get();

    	if(count($exists) == 0){

	    	$leave_type = LeaveMast::all(['id', 'total'])->toArray();

	    	//return $leave_type[0]['count'];

	    	for($i=0; $i<count($request->leave); $i++){

	    		$allotted = new LeaveAllotment;

	    		$allotted->leave_mast_id= $request->id[$i];
	    		$allotted->emp_id		= $request->emp_id;
	    		$allotted->start 		= $request->start;
	    		$allotted->end 			= $request->ends;
	    		$allotted->initial_bal 	= $request->leave[$i];
	    		$allotted->current_bal 	= $request->leave[$i];
	    		$allotted->save();
	    	}

	    	$employee = EmployeeMast::find( $request->emp_id);
		    $employee->leave_allotted = 1;
		    $employee->save();
	    }

	    return back()->with('success', 'Leave allotted successfully.');
    }

    public function edit( $id){

    	$name 		= EmployeeMast::where('id', $id)
    					->select('id', 'emp_name')
    					->first();

		$employee 	= LeaveAllotment::with('leaves')
						->where('emp_id', '=', $id)
						->get();

    	return view('leave.allotment.edit', compact('name', 'employee'));
    }

    public function update(Request $request,$id){

    	$this->validate($request, [
	    	'start'		=>	'required',
	    	'ends'		=>	'required',
	    	'leave.*'	=>	'required|numeric|between:0,99.99'
    	]);

		$count	= count($request->id);
		$x		= 0;
		$data	= '';

		while($count > $x){

			$data = [
					'start'			=>	$request->start,
					'end'			=>	$request->ends,
					'current_bal'	=>	$request->leave[$x]
					];

			LeaveAllotment::where('emp_id',$id)->where('leave_mast_id',$request->id[$x])->update($data);
			$x++;
		}

		return redirect()->route('allotments.index')->with('success', 'Updated successfully.');
    }

    public function destroy( $id){

    	LeaveAllotment::where('emp_id', $id)->delete();

    	$employee = EmployeeMast::find( $id);
    	$employee->leave_allotted = null;
    	$employee->save();

    	return redirect()->route('allotments.index')->with('success', 'Record deleted successfully.');
    }

    //Hold employee leaves
    public function hold( $id){

    	
    	LeaveAllotment::where('emp_id', $id)->delete();

    	$employee = EmployeeMast::find($id);
    	$employee->leave_allotted = null;
    	$employee->save();

    	return back()->with('success', 'Leave holded.');
    }
}
