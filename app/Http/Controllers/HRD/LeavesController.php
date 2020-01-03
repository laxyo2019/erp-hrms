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


    public function approve_leave($leave_id){
        $leaveApp  = LeaveApply::find($leave_id);
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

        $data = [
            'leave_apply_id' => $leave_id,
            'emp_id'         => $leaveApp->emp_id,
            'approver_id'    => Auth::user()->emp_id,
            'paid_count'     => $paid_leave,
            'unpaid_count'   => $unpaid_leave,
            'approver_remark'=> null,
            'actions'        => '16'
        ];

        LeaveApprovalDetail::create($data);

        return $data;


    }

    public function store(Request $request){


        // return $data;
        

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