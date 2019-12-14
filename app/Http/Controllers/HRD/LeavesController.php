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
    	/*$leave_request = DB::table('emp_leave_applies')->orderBy('id', 'DESC')
            ->where('emp_leave_applies.deleted_at', null)
            ->join('emp_mast', 'emp_leave_applies.emp_id', '=', 'emp_mast.id')
            ->join('leave_mast', 'emp_leave_applies.leave_type_id', '=', 'leave_mast.id')
            ->join('users', 'emp_leave_applies.approver_id', '=', 'users.emp_id')
            ->leftjoin('approval_actions_mast', 'emp_leave_applies.status', '=', 'approval_actions_mast.id')
            ->select('emp_leave_applies.id', 'emp_mast.id as employee_id', 'users.name', 'emp_name', 'leave_mast.name', 'emp_leave_applies.from', 'emp_leave_applies.from', 'emp_leave_applies.to', 'emp_leave_applies.count', 'emp_leave_applies.status', 'emp_leave_applies.approver_remark', 'approval_actions_mast.id as action_id', 'approval_actions_mast.name as action_name', 'emp_leave_applies.created_at')
    		->get();*/

        $leave_request = LeaveApply::with(['employee','leavetype','approve_name.UserName'])
                            ->orderBy('id', 'DESC')
                            ->get();

        return view('HRD.leaves.index', compact('leave_request', 'permissions'));
	}
	public function edit($id){

	}
    public function store(Request $request){
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
        $approval_detail->approver_remark = $request->reason;; 
        $approval_detail->save();
        return back();
    }

    public function show(Request $request, $leave_id){
        //return $leave_id;
        //$data = LeaveApply::where('id', $leave_id)
                    //->first();
        $data = LeaveApply::with(['approvalaction'])
                    ->where('id', $leave_id)
                    ->first();
        //return $data;
        return view('HRD.leaves.show', compact('data'));
    }

    public function download($id){
        $document = LeaveApply::findOrFail($id)->file_path;
        return Storage::download($document);
    }

}