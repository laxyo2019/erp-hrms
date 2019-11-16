<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master\LeaveTypeMast;
use App\Models\Master\LeaveMast;
use App\Models\Employees\LeaveApply;
use App\Models\Employees\EmployeeMast;
use App\Models\Employees\ApprovalSetup;
use App\Models\Master\ApprovalAction;
use App\Models\Employees\LeaveApprovalDetail;
use App\Models\Employees\LeaveAllotment;
use DB;
use Auth;

class LeavesController extends Controller
{
    
    public function index(){

        $type = LeaveMast::all();

        $actions = ApprovalAction::all();

        $appr_sys = ApprovalSetup::where('emp_id', Auth::id())->first();

    	$leave_request = DB::table('emp_leave_applies')
            ->where('emp_leave_applies.deleted_at', null)
            ->join('emp_mast', 'emp_leave_applies.emp_id', '=', 'emp_mast.id')
            ->join('leave_mast', 'emp_leave_applies.leave_type_id', '=', 'leave_mast.id')
            ->join('approval_actions_mast', 'emp_leave_applies.status', '=', 'approval_actions_mast.id')
            ->select('emp_leave_applies.id', 'emp_mast.id as employee_id','emp_name', 'leave_mast.name', 'emp_leave_applies.from', 'emp_leave_applies.from', 'emp_leave_applies.to', 'emp_leave_applies.count', 'emp_leave_applies.status', 'emp_leave_applies.approver_remark', 'approval_actions_mast.id as action_id', 'approval_actions_mast.name as action_name')
    		->get();

    	return view('HRD.leaves.index', compact('leave_request', 'appr_sys', 'actions'));
    	
	}

	public function edit($id){

	}

    public function leavepermission( $employee_id, $leave_id, $count, $action){

        $leave = LeaveApply::findOrFail($leave_id);
        $leave->status = $action;
        $leave->save();

        if($action == 1){
            LeaveAllotment::where('leave_mast_id', $leave->leave_type_id)
                    ->where('emp_id', $employee_id)
                    ->limit(1)
                    ->decrement('current_bal', $count);
        }

        LeaveAllotment::where('leave_mast_id', $leave->leave_type_id);

        $approval_detail = new LeaveApprovalDetail;
        $approval_detail->leave_apply_id = $leave_id;
        $approval_detail->approver_id    = Auth::id();
        $approval_detail->actions        = $action;
        $approval_detail->save();

        return back();
    }

    public function requestDetail(Request $request){

        $data = LeaveApply::where('id', $request->leave_id)
                    ->first();

        return view('HRD.leaves.detail', compact('data'));

    }

    public function download($id){

        $document = LeaveApply::findOrFail($id)->file_path;

        return Storage::download($document);
    }

}