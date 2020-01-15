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

        $actions = ApprovalAction::all();

        $leave_request  = LeaveApply::with(['employee','leavetype','approve_name.UserName', 'approvalaction'])
                            ->orderBy('id', 'DESC')
                            ->get();        

        return view('HRD.leaves.index', compact('leave_request', 'permissions', 'actions'));
	}

	public function edit($id){

	}

    public function approve_leave(Request $request, $leave_id){

        $leaveApp  = LeaveApply::find($leave_id);
        $leaveApp->approver_id = Auth::user()->emp_id;
        $leaveApp->status      = $request->action_id;
        $leaveApp->save();

        $leave_mast = LeaveMast::find($leaveApp->leave_type_id);

        $allotment = LeaveAllotment::where('leave_mast_id', $leaveApp->leave_type_id)
                    ->where('emp_id', $leaveApp->emp_id)
                    ->first();

         //from Leave applies table
        $from         = $leaveApp->from;
        $count        = $leaveApp->count;

        //from Leave allottment table
        $generated_at = $allotment->generated_at;
        $leave_bal    = $allotment->initial_bal;

         if($count <= $leave_bal){

            $paid_leave   = $count;
            $unpaid_leave = 0;
            // return "also available balnce";

        }else{

            $month = date('m',strtotime($from)) - date('m',strtotime($generated_at));
            $leave_genrate = $leave_mast->total / 12 * $month ;
         

        if(date('Y-m-d', strtotime( "+".$month. " month", strtotime( $generated_at ) )) < $from ){

               if($leaveApp->day_status == '3' || $leaveApp->day_status == '2'){
                $after_gen_bal  = floor($leave_bal + $leave_genrate);
                $unpaid_leave   =  $count - $after_gen_bal;             
                $paid_leave     = $count - $unpaid_leave;
                // return $    unpaid_leave;
               }else{
                   $paid_leave  = $count; 
                   $unpaid_leave = 0;
                } 

       
            }else{ 
                $unpaid_leave = $count;
                $paid_leave = 0;
                // return "generated not";
            }
        }

        /*$data = [
            'leave_apply_id' => $leave_id,
            'emp_id'         => $leaveApp->emp_id,
            'approver_id'    => Auth::user()->emp_id,
            'actions'        => $request->action_id,
            'paid_count'     => $paid_leave,
            'unpaid_count'   => $unpaid_leave,
            'approver_remark'=> null,
        ];*/

        $approval_history = new LeaveApprovalDetail;
        $approval_history->leave_apply_id = $leave_id;
        $approval_history->emp_id         = $leaveApp->emp_id;
        $approval_history->approver_id    = Auth::user()->emp_id;
        $approval_history->actions        = $request->action_id;
        $approval_history->paid_count     = $paid_leave;
        $approval_history->unpaid_count   = $unpaid_leave;
        $approval_history->approver_remark= null;
        $approval_history->save();

        return back()->with('success', 'Status updated');

    }

    public function store(Request $request){
      
        //Update Leave application status

        $leave  = LeaveApply::findOrFail($request->leave_request_id);
        $leave->approver_id = Auth::id();
        $leave->status      = $request->approval_action_id;
        $leave->save();

        //Leave without pay

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

    public function reverse(Request $request){

        $detail = LeaveApply::with(['approvaldetail', 'leavetype'])
            ->where('id', $request->leave_request)
            ->first();

        LeaveAllotment::where('leave_mast_id', $detail->leave_type_id)
            ->where('emp_id', $detail->emp_id)
            ->increment('initial_bal', $detail->count);

    /*  $carry_leave = new LeaveApprovalDetail;
        $carry_leave->leave_mast_id =
        $carry_leave->emp_id =
        $carry_leave->status =
        $carry_leave->start =
        $carry_leave->end =
        $carry_leave->leave_mast_id =
    */

        LeaveApprovalDetail::create([
            'leave_apply_id'  => $detail->id,
            'emp_id'          => $detail->emp_id,
            'approver_id'     => Auth::user()->emp_id,
            'actions'         => $detail->id,
            'paid_count'      => 0,
            'unpaid_count'    => 0,
            'carry'           => $detail->count,
            'approver_remark' => $detail->approver_remark,
        ]);


        return back()->with('success', 'Reversed leaves successfully.');
    }

}