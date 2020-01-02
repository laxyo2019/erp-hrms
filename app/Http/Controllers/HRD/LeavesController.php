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
use Spatie\Permission\Models\Permission;
use App\Models\Spatie\ModelPermission;
use Spatie\Permission\Models\Role;
use App\Models\Spatie\ModelRole;
use App\User;
use DB;
use Auth;

class LeavesController extends Controller
{
    public function index(){

        $user           = User::find(Auth::user()->id);
        $permissions    = $user->getAllPermissions();
    	
        $leave_request  = LeaveApply::with(['employee','leavetype','approve_name.UserName', 'approvalaction'])
                            ->orderBy('id', 'DESC')
                            ->get();

        return view('HRD.leaves.index', compact('leave_request', 'permissions'));
	}

	public function edit($id){

	}

    public function store(Request $request){

        $leaveApp  = LeaveApply::find($request->leave_request_id);
        $allotment = LeaveAllotment::where('leave_mast_id', $leaveApp->leave_type_id)
                    ->where('emp_id', $leaveApp->emp_id)
                    ->first();

        $leave_generated_after = LeaveMast::find($leaveApp->leave_type_id)->generates_in;

        //return ([$leave, $allotment]);
        $today = date('Y-m-d');

        $start = $leave->starts_dt;
        $count = $leave->count;
        $last_generated = $allotment->last_generated;
        $leave_bal = $allotment->intial_bal;

        if($leave){

        }

        //Update Leave application status

        $leave  = LeaveApply::findOrFail($request->leave_request_id);
        $leave->approver_id = Auth::id();
        $leave->status      = $request->approval_action_id;
        $leave->save();

        //Update user leave balance from allotment table if APPROVED

        $acd = Permission::find($request->approval_action_id);
        if($acd->name == 'decline'){
            LeaveAllotment::where('leave_mast_id', $leave->leave_type_id)
                    ->where('emp_id', $leave->emp_id)
                    ->limit(1)
                    ->increment('current_bal', $leave->count);
        }

        // Create log for actions taken on leave requests
        
        $approval_detail = new LeaveApprovalDetail;
        $approval_detail->leave_apply_id = $request->leave_request_id;
        $approval_detail->approver_id    = Auth::id();
        $approval_detail->actions        = $request->approval_action_id;
        $approval_detail->approver_remark= $request->reason;; 
        $approval_detail->save();
        return back();
    }

    public function show(Request $request, $leave_id){

        $data = LeaveApply::with(['approvalaction'])
                    ->where('id', $leave_id)
                    ->first();
        
        return view('HRD.leaves.show', compact('data'));
    }

    public function download($id){

        $document = LeaveApply::findOrFail($id)->file_path;
        return Storage::download($document);
    }

}