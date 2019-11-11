<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employees\EmployeeMast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use File;
use App\Models\Employees\EmpLeave;
use App\Models\Master\LeaveMast;
use App\Models\Employees\LeaveApply;
use App\Models\Master\ApprovalAction;
use App\Models\Master\Designation;
use Illuminate\Support\Facades\Storage;
use App\Models\Employees\LeaveAllotment;


class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leave_type = LeaveMast::all();
        $action     = ApprovalAction::all();
        
        
        $employee   = EmployeeMast::with(['leaveapplies'])->where('id', Auth::id())->first();
        //return $employee['leaveapplies'][1]->id;
        return view('employee.leaves.index', compact('leave_type', 'employee', 'action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Many2Many relationship

        //$desig = Designation::find(3)->approvals;
        
        $parent_id = EmployeeMast::find(Auth::id())->parent_id;

        //for logged in user's teamLead

        $team_lead = EmployeeMast::where('id', $parent_id)
                    ->select('id', 'emp_name')
                    ->first();

        $leave_type = LeaveMast::all();

        return view('employee.leaves.create', compact('leave_type', 'team_lead'));
    }

    public function balance(Request $request){
       
        $first_date = date_create($request->start_date);
        $last_date  = date_create($request->end_date);

        $difference = date_diff($first_date, $last_date);
        $count      = $difference->format("%a")+1;

        $allotment = LeaveAllotment::find(Auth::id())
                        ->where('leave_mast_id', $request->leave_type)
                        ->first();

        if($count <= $allotment->current_bal){
            $data = array(
                'days' =>  $count,
                'msg'  =>  1

            );
            return json_encode($data);

        }else{

            $data = [
                        'days' => $count,
                        'msg'  => 0
                    ];
            
            return json_encode($data);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
          'leave_type_id'   => 'required'
        ]);

        $id = Auth::id();

        //duration of leaves

        $first_date = date_create($request->start_date);
        $last_date  = date_create($request->end_date);

        $difference = date_diff($first_date, $last_date);

        $count = $difference->format("%a");

        //Uploading documents to hrmsupload directory

        if($request->hasFile('file_path')){

          $dir      = 'hrms_uploads/'.date("Y").'/'.date("F").'/leave';
          $file_ext = $request->file('file_path')->extension();
          $filename = $id.'_'.time().'_leaves.'.$file_ext;
          $path     = $request->file('file_path')->storeAs($dir, $filename);

        }else{

          $path = null;

        }

        $leaveapply = new LeaveApply;
        $leaveapply->emp_id            = $id;
        $leaveapply->teamlead_id       = $request->team_lead_id;
        $leaveapply->leave_type        = $data['leave_type_id'];
        $leaveapply->from              = $request->start_date;
        $leaveapply->to                = $request->end_date;
        $leaveapply->count             = $count;
        $leaveapply->reason            = $request->reason;
        $leaveapply->file_path         = $path;
        $leaveapply->addr_during_leave = $request->address_leave;
        $leaveapply->contact_no        = $request->contact_no;
        $leaveapply->status            = 3;
        $leaveapply->applicant_remark  = $request->applicant_remark;
        $leaveapply->approver_remark   = null;
        $leaveapply->hr_remark         = null;
        $leaveapply->save();

       return redirect('employee/leaves')->with('success','Applied successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('employee.leaves.show');
    }

    public function showrequest(Request $request){

        $leave_req = LeaveApply::find($request->id);

        return view('employee.leaves.show', compact('leave_req'));
    }

    public function apply_leaves($id){

    	return view('employee.leaves.apply');

    }

    public function applyform(){

        $leave_type = LeaveMast::all();
        return $leave_type;

        return view('employee.leaves.create');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leave_type = LeaveMast::all();

        $leaves = LeaveApply::findOrFail($id);
    
        return view('employee.leaves.edit', compact('leaves', 'leave_type')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = request()->validate([
          'leave_type_id'   => 'required'
        ]);

        //duration of leaves

        $first_date = date_create($request->start_date);
        $last_date  = date_create($request->end_date);

        $difference = date_diff($first_date, $last_date);

        $count = $difference->format("%a");

        if($request->hasFile('file_path')){

            //Delete file and save null in file_path column
            $file = LeaveApply::find($id);
            Storage::delete($file->file_path);
            $file->file_path = null;
            $file->save();

            //Save new file
            $dir      = 'hrms_uploads/'.date("Y").'/'.date("F");
            $file_ext = $request->file('file_path')->extension();
            $filename = $id.'_'.time().'_leaves.'.$file_ext;
            $path     = $request->file('file_path')->storeAs($dir, $filename);

        }else{

            $path = LeaveApply::find($id)->file_path;

        }

        $leaveapply = LeaveApply::findOrFail($id);
        $leaveapply->emp_id            = Auth::id();
        $leaveapply->teamlead_id       = $request->team_lead_id;
        $leaveapply->leave_type        = $data['leave_type_id'];
        $leaveapply->from              = $request->start_date;
        $leaveapply->to                = $request->end_date;
        $leaveapply->count             = $count;
        $leaveapply->reason            = $request->reason;
        $leaveapply->file_path         = $path;
        $leaveapply->addr_during_leave = $request->address_leave;
        $leaveapply->contact_no        = $request->contact_no;
        $leaveapply->status            = 3;
        $leaveapply->applicant_remark  = $request->applicant_remark;
        $leaveapply->approver_remark   = null;
        $leaveapply->hr_remark         = null;
        $leaveapply->save();

        return back()->with('success', 'Updated successfully');
    }

    public function download($id){

        $document = LeaveApply::findOrFail($id)->file_path;

        return Storage::download($document);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leave_app = LeaveApply::findOrFail($id);
        Storage::delete($leave_app->file_path);
        $leave_app->delete();
        return back()->with('success', 'Record deleted successfully');

    }

    public function showindex(){

        $leaves = LeaveApply::findOrFail(Auth::id());
        return view('employee.leaves.index', compact('leaves'));
    }

    public function emp_leave()
    {
        $leave_type = DB::table('leave_type_mast')->get();
        return view('employee.leaves.leave',compact('leave_type'));
    }
}
