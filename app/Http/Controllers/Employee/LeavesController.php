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
use App\Models\Master\Designation;
use Illuminate\Support\Facades\Storage;
use App\Models\Employees\LeaveAllotment;
use App\Models\Master\Holiday;
use DateTime;
use App\User;


class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   public function __construct(){

      $this->middleware('auth');
      
    }

   public function index()
   {

      $emp        = EmployeeMast::find(Auth::user()->emp_id)
                      ->first();
      $employee   = EmployeeMast::with(['leaveapplies','UserName','approve_name'])
                      ->orderBy('created_at', 'DESC')
                      ->where('id', Auth::user()->emp_id)
                      ->latest()
                      ->first();

      $balance    = EmployeeMast::with('allotments.leaves')
                      ->where('id', Auth::user()->emp_id)
                      ->latest()
                      ->first();

      $parent_id  = EmployeeMast::find(Auth::user()->emp_id)              ->parent_id;

      $leaves = LeaveMast::all();

      return view('employee.leaves.index', compact('employee', 'balance'));
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
     $reports_id = EmployeeMast::find(Auth::user()->emp_id)->reports_to;
       if(!empty($reports_id)){

         //for logged in user's reports to
         $reports_to = EmployeeMast::where('id', $reports_id)
                   ->select('id', 'emp_name')
                   ->first();
       }else{
         $reports_to = null;
       }


      //Get all allotted Leaves of current employee.
      $allotment = LeaveAllotment::with('leaves')
                    ->where('emp_id', Auth::user()->emp_id)
                ->get();

      $leaves = [];

      foreach($allotment as $data){

        $leaves[] = LeaveMast::where('id', $data->leave_mast_id)
                      ->first();
      }

      //return $allotment;

      //return LeaveAllotment::with('leaves')
                //->get();
      return view('employee.leaves.create', compact('leaves', 'reports_to', 'allotment'));
   }

   public function balance(Request $request){


      //Get leave type

      $leave    = LeaveMast::where('id', $request->leave_id)
                  ->orWhere('name', $request->leaveType)
                  ->first();

      // Get user's balance of selected leave

      $data['user_bal'] = LeaveAllotment::where('emp_id', Auth::user()->emp_id)
                              ->where('leave_mast_id', $leave->id)
                              ->first();

      //return $data['user_bal']->initial_bal;
      //Get holidays
      $holidays = Holiday::all();

      // Check leave applied by user

      $user_applied_leaves = LeaveApply::where('emp_id', Auth::user()->emp_id)->get();

      $data['leave_bal']        = $leave->count;
      $data['min_apply_once']   = $leave->min_apply_once;
      $data['max_apply_once']   = $leave->max_apply_once;
      $data['max_daysIn_month'] = $leave->max_days_month;
      $data['max_applyIn_month']= $leave->max_apply_month;
      $data['max_apply_year']   = $leave->max_apply_year;
      $data['carry_forward']    = $leave->carry_forward;
      $data['docs_required']    = $leave->docs_required;
      $data['without_pay']      = $leave->without_pay;
      $data['holidays']         = $holidays;
      

      return $data;

   /********Old Code***********/
      //For multiple days leave
      /*if($request->day == 'multi'){
          $first_date   = date_create($request->start_date);
          $last_date    = date_create($request->end_date);
          $difference   = date_diff($first_date, $last_date);
          
          $count        = $difference->format("%a")+1;
          $sandwichRule = Holiday::select('id', 'title', 'date')
          ->whereBetween('date', [$request->start_date, $request->end_date])
          ->get();

          //return $difference;

          $startDate  = new DateTime($request->start_date);
          $endDate    = new DateTime($request->end_date);
          $sundays = [];

      for($i=0; $startDate <= $endDate; $startDate->modify('+1 day')){
        if($startDate->format('w') == 0){
          $sundays[] = $startDate->format('Y-m-d');
           // return count($sundays);
            // return $sundays;
        }
      }

      // return $sandwichRule;
       
      }elseif ($request->day == 'full') { //for single days
        $sandwichRule = null;
        $count = 1;
      }else{                              //for half days
        $sandwichRule = null;
        $count = 0.5;
      }
      //find user and his leave balance
      $allotment  = LeaveAllotment::where([
                        ['emp_id', Auth::user()->emp_id],
                        ['leave_mast_id', $request->leave_type],
                      ])->first();

      //Check how many time sick leave is applied
      $casualcount = LeaveApply::where('emp_id', Auth::user()->emp_id)
                        ->where('leave_type_id', 3)
                        ->whereBetween('created_at', [date('01-m-Y'), $request->end_date])
                        ->count();

      //return $counter;

      if($count <= $allotment->current_bal){
          $data = [
            'days' =>   $count,
            'rule' =>   $sandwichRule,
            'msg'  =>   0];
      }else{
          $data = [
            'days' =>   $count,
            'rule' =>   $sandwichRule,
            'msg'  =>   1 ];           
      }*/
   /****/
   }
  
   public function holidayCheck(Request $request){

    $sandwichRule = Holiday::select('id', 'title', 'date')
                      ->where('date', '>', $request->start)
                      ->where('date', '<', $request->end )
                      ->get();
     
    $check = count($sandwichRule);
    return $check;
   }

   public function store(Request $request)
   {
    //return $request->all();

     $data = $request->validate([
         'leave_type_id' => 'required',
         'reports_to'    => 'required',
         'start_date'    => 'required',
         'reason'        => 'required',
         'duration'      => 'required|string',
         'contact_no'    => 'nullable',
         'applicant_remark'=> 'nullable',
         'address_leave'=> 'nullable'       

      ]);


      $btnId = $request->btnId;

      $leaveData = LeaveMast::where('id', $request->leave_type_id)
                  ->first();

      //$without_pay =  LeaveMast::where('id', $request->leave_type_id)
      //->first()->without_pay;

    if($leaveData->without_pay == 1){

      if($btnId == 'multiBtn'){

         $endDate = $request->validate([
            'end_date' => 'required',
         ]);

        $data['end_date'] = $endDate['end_date'];

      }elseif($btnId == 'halfBtn'){

         $dayStatus = $request->validate([
            'day_status'  => 'required',
         ]);
          $data['day_status'] = $dayStatus['day_status'];
      }
    }

      //If min leave starts from half day

      if($leaveData->min_apply_once == 0.5){

        if($leaveData->max_apply_once == 0.5){

          $dayStatus = $request->validate([

            'day_status'  => 'required',
            ]);

            $data['day_status'] = $dayStatus['day_status'];
         }

         if($leaveData->max_apply_once > 1 || $leaveData->max_apply_once == null )
         {

            if($btnId == 'multiBtn'){

               $endDate =$request->validate([
                  'end_date' => 'required',
               ]);  
              $data['end_date'] = $endDate['end_date'];

            }elseif($btnId == 'halfBtn'){

               $dayStatus = $request->validate([
                  'day_status'  => 'required',
               ]);
                $data['day_status'] = $dayStatus['day_status'];
            }

         }
         //If min leave starts from 1 day
         }elseif($leaveData->min_apply_once == 1 ){

           if($leaveData->max_apply_once > 1 || $leaveData->max_apply_once == null)
            {
              if($request->btnId == 'multiBtn'){
                $endDate =  $request->validate([
                    'end_date' => 'required',
                 ]); 
                $data['end_date'] = $endDate['end_date']; 
              }
            }

         }else{

            if($request->btnId == 'multiBtn'){
              $endDate =  $request->validate([
                  'end_date' => 'required',
               ]);  
               $data['end_date'] = $endDate['end_date']; 
            }
         }

      if($leaveData->docs_required){

         $request->validate([
            'file_path' => 'required'
         ]);
      }

      if($btnId == 'multiBtn'){

        $data['day_status'] = 3;

      }elseif($btnId == 'fullBtn'){

        $dayStatus = $request->validate([
                  'day_status'  => 'required',
               ]);

        $data['day_status'] = 2;

      }elseif($btnId == 'halfBtn'){

        $dayStatus = $request->validate([
                  'day_status'  => 'required',
               ]);
        $data['day_status'] = $dayStatus['day_status'];

        //Check if string then store half day(0.50)
        $type = gettype($request->duration);

        if($type == 'string'){

          $request->duration = '0.50';
        }
      }


      //return $request->all();
    

    //return $data;
    //return 'no error';
      

    // return $leaveData;
    //   $data = request()->validate([
    //     'leave_type_id' => 'required',
    //     'reports_to'    => 'required',
    //     'start_date'    => 'required',
    //     'count'         => 'required',
    //     'file_path'     => 'sometimes|required',
    //     'leave_type_id' => 'required',
    //     'reports_to'    => 'required',
    //     'start_date'    => 'required'
    //   ]);
    //   //return $request->all();
    //   $leave_type = LeaveMast::where('id',$data['leave_type_id'])->first();

    //   if( $leave_type->name == 'Sick Leave'){
    //     $data = request()->validate([
    //     'file_path'     => 'required',
    //     'leave_type_id' => 'required',
    //     'reports_to'    => 'required',
    //     'start_date'    => 'required',
    //     'count'         => 'required',]);
    //   }

       $id = Auth::user()->emp_id;

    //   //Store full, first/second half day

    //   switch($request->day){
    //     case "full":
    //       $request->full_day = 1;
    //       break;

    //     case "first_half":
    //       $request->first_half = 1;
    //       break;

    //     case "second_half":
    //       $request->second_half = 1;
    //       break;
    //   }



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
    $leaveapply->reports_to        = $request->reports_to;
    $leaveapply->leave_type_id     = $request->leave_type_id;
    $leaveapply->day_status        = $data['day_status'];
    $leaveapply->from              = $request->start_date;
    $leaveapply->to                = $request->end_date;
    $leaveapply->count             = $request->duration;
    $leaveapply->reason            = $request->reason;
    $leaveapply->file_path         = $path;
    $leaveapply->addr_during_leave = $request->address_leave;
    $leaveapply->contact_no        = $request->contact_no;
    $leaveapply->status            = null;
    $leaveapply->applicant_remark  = $request->applicant_remark;
    $leaveapply->approver_remark   = null;
    $leaveapply->hr_remark         = null;
    $leaveapply->save();
      
    //Deduct leave when employee apply for it & add if declined
    /*$leave = LeaveAllotment::where([
                  ['emp_id', Auth::user()->emp_id],
                  ['leave_mast_id', $request->leave_type_id]])
                  ->limit(1)
                  ->decrement('current_bal', $request->duration);*/


    return redirect('employee/leaves')->with('success','Applied successfully');
    }

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
        // return $leave_type;
        return view('employee.leaves.create');
    }
    
    /*public function edit( $id)
    {
        $leave_type   = LeaveMast::all();
        $leaves       = LeaveApply::where('id', $id)
                            ->with('reportsto')
                            ->first();

        return view('employee.leaves.edit', compact('leaves', 'leave_type')) ;
    }
    public function update(Request $request, $id)
    {
        $data = request()->validate([
          'leave_type_id'   => 'required'
        ]);

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
        $leaveapply->reports_to        = $request->team_lead_id;
        $leaveapply->leave_type_id     = $data['leave_type_id'];
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
        $leaveapply->save();
        return back()->with('success', 'Updated successfully');
    }
*/
    public function download($id){
        $document = LeaveApply::findOrFail($id)->file_path;
        return Storage::download($document);
    }

    public function destroy($id)
    {
        $leave_app = LeaveApply::findOrFail($id);

        Storage::delete($leave_app->file_path);
        $leave_app->delete();

        /***Add leave balance to employee if leave application is deleted***/
        /*LeaveAllotment::where('leave_mast_id', $leave_app->leave_type_id)
                      ->where('emp_id', $leave_app->emp_id)
                      ->increment('current_bal', $leave_app->count);
        */
        return back()->with('success', 'Record deleted successfully');
    }

    public function emp_leave()
    {
        $leave_type = DB::table('leave_type_mast')->get();
        return 542;
        return view('employee.leaves.leave',compact('leave_type'));
    }

    /*public function balance(){
      $allotted = EmployeeMast::find(Auth::user()->emp_id)->first();
      $leaves = $allotted->leave_allotted;

    }*/
}
