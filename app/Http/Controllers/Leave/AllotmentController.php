<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employees\EmployeeMast;
use App\Models\Master\LeaveMast;
use App\Models\Employees\LeaveAllotment;

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

	public function create(){

		return redirect()->route('allotments.index')->with('success', 'Success updated');
	}

    public function store( $id){

    	$exists = LeaveAllotment::where('emp_id', $id)->get();

    	if(count($exists) == 0){

	    	$leave_type = LeaveMast::all(['id'])->toArray();

	    	for($i=0; $i<count($leave_type); $i++){

	    		$allotted = new LeaveAllotment;

	    		$allotted->leave_mast_id= $leave_type[$i]['id'];
	    		$allotted->emp_id		= $id;
	    		$allotted->start 		= date("Y-m-d");
	    		$allotted->end 			= date('Y-m-d', strtotime('Dec 31'));
	    		$allotted->current_bal 	= 10;
	    		$allotted->save();
	    	}

	    	$employee = EmployeeMast::find( $id);
		    $employee->leave_allotted = 1;
		    $employee->save();
	    }

	    return 'Leave Allotted ';
    }

    public function edit( $id){

    	$name = EmployeeMast::where('id', $id)
    				->select('id', 'emp_name')
    				->first();

		$employee = LeaveAllotment::with('leaves')
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
}
