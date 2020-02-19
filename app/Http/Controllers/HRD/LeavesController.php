<?php

namespace App\Http\Controllers\HRD;

use DB;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Models\Spatie\ModelRole;
use App\Models\Master\LeaveMast;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Master\LeaveTypeMast;
use App\Models\Employees\LeaveApply;    
use App\Models\Employees\EmployeeMast;
use App\Models\Spatie\ModelPermission;
use App\Models\Employees\LeaveAllotment;
use Spatie\Permission\Models\Permission;
use App\Models\Employees\LeaveApprovalDetail;

class LeavesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $user = User::find(Auth::user()->id);
        
        /* For Team Lead */
        if($user->hasRole('hrms_teamlead')){

            $leave_request  = LeaveApply::with(['employee','leavetype','approve_name.UserName', 'approvaldetail'])
                ->orderBy('id', 'DESC')
                ->where('user_id', '<>', Auth::id())
                ->where('reports_to', Auth::id())
                ->get();

        /* For HR */    

        }elseif($user->hasRole('hrms_hr')){

            $leave_request  = LeaveApply::with(['employee','leavetype','approve_name.UserName', 'approvaldetail'])
                ->orderBy('id', 'DESC')
                ->where('user_id', '<>', Auth::id())
                ->whereIn('teamlead_approval', [1, 3])
                ->get();

        /* For Admin*/
        }elseif($user->hasRole('hrms_admin')){

            $leave_request  = LeaveApply::with(['employee','leavetype','approve_name.UserName', 'approvaldetail'])
                ->orderBy('id', 'DESC')
                ->where('user_id', '<>', Auth::id())
                ->whereIn('subadmin_approval', [1, 3])
                ->get();
        }

        return view('HRD.leaves.index', compact('leave_request'));
	}

	public function edit($id){

	}

    public function approve_leave(Request $request, $request_id){

    	$data = User::find(Auth::user()->id);

        //Update leave aaplication status and approver' id.

        $leaveApp  = LeaveApply::find($request_id);
        $leaveApp->reason = $request->reason;
        $leaveApp->save();

        //Check if ID 1(APPROVE)

        if($request->action == 1){

        // 
            //$allotment  = LeaveAllotment::where('leave_mast_id', $leaveApp->leave_type_id)
            //             ->where('emp_id', $leaveApp->emp_id)
            //             ->first();

            //  //from Leave applies table
            // $from         = $leaveApp->from;
            // $count        = $leaveApp->count;

            // //from Leave allottment table
            // $generated_at = $allotment->generated_at;
            // $leave_bal    = $allotment->initial_bal;

            // if($count <= $leave_bal){

            //     $paid_leave   = $count;
            //     $unpaid_leave = 0;
            //     // return "also available balance";

            // }else{

            //     $month = date('m',strtotime($from)) - date('m',strtotime($generated_at));
            //     $leave_genrate = $leave_mast->total / 12 * $month ;
             

            //     if(date('Y-m-d', strtotime( "+".$month. " month", strtotime( $generated_at ) )) < $from ){

            //        if($leaveApp->day_status == '3' || $leaveApp->day_status == '2'){
            //         $after_gen_bal  = floor($leave_bal + $leave_genrate);
            //         $unpaid_leave   =  $count - $after_gen_bal;             
            //         $paid_leave     = $count - $unpaid_leave;
            //         // return $    unpaid_leave;
            //        }else{
            //            $paid_leave  = $count; 
            //            $unpaid_leave = 0;
            //         } 

            //     }else{ 
            //         $unpaid_leave = $count;
            //         $paid_leave = 0;
            //     }
            // }
        //  
            if($data->hasrole('hrms_teamlead')){

                LeaveApply::where('id',$request_id)->update(['teamlead_approval' => $request->action]);

                //Update record when application approve

                $approval_history = new LeaveApprovalDetail;
                $approval_history->leave_apply_id = $request_id;
                $approval_history->user_id        = $leaveApp->user_id;
                $approval_history->approver_id    = json_encode(
                        ['teamlead_approval' => Auth::id()]);
                $approval_history->save();

            }
            elseif($data->hasrole('hrms_hr')){

                LeaveApply::where('id',$request_id)->update(['subadmin_approval' => $request->action]);

                //Update record when application approve


                $detail = LeaveApprovalDetail::where('leave_apply_id', $request_id)->first();

                $json = json_decode($detail['approver_id']);

                LeaveApprovalDetail::where('leave_apply_id', $request_id)
                    ->update([
                    'approver_id' => json_encode(
                    ['teamlead_approval' => $json->teamlead_approval,
                     'subadmin_approval' => Auth::id() ])
                        ]);

            }elseif($data->hasrole('hrms_admin')){

                LeaveApply::where('id',$request_id)->update(['admin_approval' => $request->action]);

                //Update record when application approve

                $detail = LeaveApprovalDetail::where('leave_apply_id', $request_id)->first();

                $json = json_decode($detail['approver_id']);

                LeaveApprovalDetail::where('leave_apply_id', $request_id)
                    ->update([
                    'approver_id' => json_encode(
                        ['teamlead_approval' => $json->teamlead_approval,
                         'subadmin_approval' => $json->subadmin_approval,
                         'admin_approval' => Auth::id() ]) ]);
            }

        }else{

            if($data->hasrole('hrms_teamlead')){

                LeaveApply::findOrFail($request_id)
                        ->update([
                            'teamlead_approval' => $request->action,
                            'approver_remark'   => $request->text]);
            }
            elseif($data->hasrole('hrms_hr')){

                LeaveApply::findOrFail($request_id)
                        ->update([
                            'subadmin_approval' => $request->action,
                            'approver_remark'   => $request->text]);

            }elseif($data->hasrole('hrms_admin')){

                LeaveApply::findOrFail($request_id)
                        ->update([
                            'admin_approval' => $request->action,
                            'approver_remark'=> $request->text]);
            }

            //Update leave balance if request declined.
            $leave_mast = LeaveMast::find($leaveApp->leave_type_id);

            if($leave_mast->without_pay != 1){
                
                //Increment leave balance if declined
                LeaveAllotment::where('leave_mast_id', $leaveApp->leave_type_id)
                    ->where('user_id', $leaveApp->user_id)
                    ->increment('initial_bal', $leaveApp->paid_count);

                $withoutpay_id = LeaveMast::where('without_pay', 1)
                    ->first()
                    ->id;

                if($leaveApp->unpaid_count != null){

                //Decrement unpaid_count from initial_bal if leave added to unpaid count for leave without pay leave.
                    LeaveAllotment::where('leave_mast_id', $withoutpay_id)
                        ->where('user_id', $leaveApp->user_id)
                        ->decrement('initial_bal', $leaveApp->unpaid_count);
                }

            }else{
                LeaveAllotment::where('leave_mast_id', $leaveApp->leave_type_id)
                    ->where('user_id', $leaveApp->user_id)
                    ->decrement('initial_bal', $leaveApp->count);
            }

        }

        $res['request_id'] = $request_id;
        $res['action']     = $request->action;

        return $res;

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
                    ->increment('initial_bal', $leave->count);
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

        $data = LeaveApply::where('id', $leave_id)
                    ->first();
        
        return view('HRD.leaves.show', compact('data'));
    }

    public function download($id){

        $document = LeaveApply::findOrFail($id)->file_path;
        return Storage::download($document);
    }

    public function reverse($request_id){

        $detail = LeaveApply::with(['approvaldetail', 'leavetype'])
            ->where('id', $request_id)
            ->first();


        //return $detail->count;

        //Update leave status and carry

        if(Auth::user()->hasrole('hrms_teamlead')){

            LeaveApply::where('id', $request_id)
                    ->update([
                        'teamlead_approval' => 3,
                        'carry_count'  => $detail->count,
                        'paid_count'=> 0,
                        'unpaid_count'=>0]);
        }
        elseif(Auth::user()->hasrole('hrms_hr')){

            LeaveApply::where('id', $request_id)
                    ->update([
                        'subadmin_approval' => 3,
                        'carry_count'  => $detail->count,
                        'paid_count'=> 0,
                        'unpaid_count'=>0]);
        }else{
            LeaveApply::where('id', $request_id)
                    ->update([
                        'admin_approval' => 3,
                        'carry_count'  => $detail->count,
                        'paid_count'=> 0,
                        'unpaid_count'=>0]);
        }

        //Find Leave with Leave_type_id

        //$leave = LeaveMast::where('id', $detail->leave_type_id)->first();

        //Increment/Decrement Leave allotment balance if its without pay

        if($detail['leavetype']->without_pay == 1){
            LeaveAllotment::where('leave_mast_id', $detail->leave_type_id)
                        ->where('user_id', $detail->user_id)
                        ->decrement('initial_bal', $detail->count);
        }else{
            LeaveAllotment::where('leave_mast_id', $detail->leave_type_id)
                        ->where('user_id', $detail->user_id)
                        ->increment('initial_bal', $detail->count);
        }

        //Update id of the user who reversed leave request.

        LeaveApprovalDetail::where('leave_apply_id', $request_id)
            ->update(['reversed_by' => Auth::id()]);

        return 'Leave reversed.';
    }

}