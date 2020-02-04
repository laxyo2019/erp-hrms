<?php

namespace App\Http\Controllers\Employee;

use Auth;
use File;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Master\Holiday;
use App\Models\Master\LeaveMast;
use App\Models\Master\Designation;
use App\Models\Employees\EmpLeave;
use Illuminate\Support\Facades\DB;
use App\Models\Employees\LeaveApply;
use App\Http\Controllers\Controller;
use App\Models\Employees\EmployeeMast;
use Illuminate\Support\Facades\Storage;
use App\Models\Employees\LeaveAllotment;


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

  public function index(){

    $leaves   =  LeaveApply::where('user_id', Auth::id())
                  ->with(['employee', 'approve_name', 'approvalaction', 'leavetype'])
                  ->get();

    $balance  = EmployeeMast::with('allotments.leaves')
                  ->where('user_id', Auth::id())
                  ->latest()
                  ->first();

    return view('employee.leaves.index', compact('leaves', 'balance'));
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

    $reports_to = EmployeeMast::with('UserName')
                    ->where('user_id', Auth::id())
                    ->first();
  /*
    $reports_id = EmployeeMast::where('user_id', Auth::id());
     if(!empty($reports_id)){

       //for logged in user's reports to
       $reports_to = EmployeeMast::where('user_id', $reports_id)
                 ->select('id', 'user_id', 'emp_name')
                 ->first();
     }else{
       $reports_to = null;
     }
  */
    //Get all allotted Leaves of current employee.
    $allotment = LeaveAllotment::with('leaves')
                  ->where('user_id', Auth::id())
                  ->orderBy('leave_mast_id', 'asc')
                  ->get();

    return view('employee.leaves.create', compact('reports_to', 'allotment'));
  }

   public function balance(Request $request){


      //Get leave type

      $leave    = LeaveMast::where('id', $request->leave_id)
                  ->orWhere('name', $request->leaveType)
                  ->first();

      // Get user's balance of selected leave

      $data['user_bal'] = LeaveAllotment::where('user_id', Auth::id())
                          ->where('leave_mast_id', $leave->id)
                          ->first();

      //Get holidays
      $holidays = Holiday::all();

      // Check leave applied by user

      $user_applied_leaves = LeaveApply::where('user_id', Auth::id())->get();

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
                        ['emp_id', Auth::id()],
                        ['leave_mast_id', $request->leave_type],
                      ])->first();

      //Check how many time sick leave is applied
      $casualcount = LeaveApply::where('emp_id', Auth::id())
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

     $data = $request->validate([
         'leave_type_id'    => 'required',
         //'reports_to'       => 'required',
         'start_date'       => 'required',
         'reason'           => 'required',
         'duration'         => 'required|string',
         'contact_no'       => 'nullable',
         'applicant_remark' => 'nullable',
         'address_leave'    => 'nullable'       

      ]);

      $btnId = $request->btnId;

      $leaveData = LeaveMast::where('id', $request->leave_type_id)
                  ->first();

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

      if($btnId == 'multiBtn'){

        $data['day_status'] = 3;

        if($request->duration > 2 && $leaveData->without_pay != 1){
          
          //Get all sundays
          $start = Carbon::parse($request->start_date)->next(Carbon::SUNDAY);
          $end   = Carbon::parse($request->end_date);

          $sundays = [];

          for($i = $start; $i->lt($end); $i->addWeek() ){
            $sundays[] = $i->format('Y-m-d');
          }

          //Get all Holidays
          $holidays = Holiday::where('date', '>', $request->start_date)
                        ->where('date', '<', $request->end_date )
                        ->get();

          $holidays_list = [];

          foreach($holidays as $index){

            $holidays_list[] = $index->date;
          }

          $balance = LeaveAllotment::where('leave_mast_id', $request->leave_type_id)
                      ->where('user_id', Auth::id())
                      ->first();

          $sandwich_days = array_unique(array_merge($sundays, $holidays_list));

          $paid_count    = $request->duration - count($sandwich_days);

          $unpaid_count  = $request->duration - $paid_count;

        }else if($leaveData->without_pay == 1){

          $paid_count   = 0.0;

          $unpaid_count = $request->duration;

        }else{
          
          $paid_count   = $request->duration;

          $unpaid_count = 0.0;
        }

      }elseif($btnId == 'fullBtn'){

        $dayStatus = $request->validate([
                  'day_status'  => 'required',
               ]);

        $data['day_status'] = 2;
        $paid_count = $request->duration;
        $unpaid_count = 0.0;

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

        $paid_count = $request->duration;
        $unpaid_count = 0.0;
      }

/*
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
*/
    $user_id = Auth::id();

    //Uploading documents to hrmsupload directory
    if($request->hasFile('file_path')){

      $dir      = 'hrms_uploads/'.date("Y").'/'.date("F").'/leave';
      $file_ext = $request->file('file_path')->extension();
      $filename = $user_id.'_'.time().'_leaves.'.$file_ext;
      $path     = $request->file('file_path')->storeAs($dir, $filename);
      
    }else{

      $path = null;

    }

    $leaveapply = new LeaveApply;
    $leaveapply->user_id           = $user_id;
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
    $leaveapply->paid_count        = $paid_count;
    $leaveapply->unpaid_count      = $unpaid_count;
    $leaveapply->applicant_remark  = $request->applicant_remark;
    $leaveapply->save();
      
    //Deduct/Add leave based on without pay is active or not.

    if($leaveData->without_pay != 1){

      //Decrement balance from initial_bal
      $leave = LeaveAllotment::where([
                ['user_id', Auth::id()],
                ['leave_mast_id', $request->leave_type_id]])
                ->limit(1)
                ->decrement('initial_bal', $paid_count);

      //Increment balance of initial_bal of without_pay
      $without_payid = LeaveMast::where('without_pay', 1)
                          ->first()
                          ->id;


      LeaveAllotment::where([
                ['user_id', Auth::id()],
                ['leave_mast_id', $without_payid]])
                ->limit(1)
                ->increment('initial_bal', $unpaid_count);

    }else{
      LeaveAllotment::where([
                ['user_id', Auth::id()],
                ['leave_mast_id', $request->leave_type_id]])
                ->limit(1)
                ->increment('initial_bal', $request->duration);
    }

    return redirect('employee/leaves')->with('success','Applied successfully');
    }

 
    public function download($id){
        $document = LeaveApply::findOrFail($id)->file_path;
        return Storage::download($document);
    }

    public function destroy($id)
    {
      
      $leave_app = LeaveApply::findOrFail($id);
      

      /**Add leave balance back if leave application is deleted**/

      $leavesMast = LeaveMast::where('id', $leave_app->leave_type_id)
        ->first();

      //Increment/Decrement leaves based on pay or without pay

      if($leavesMast->without_pay != 1){

        //Increment paid_count from initial bal

        LeaveAllotment::where('leave_mast_id', $leave_app->leave_type_id)
            ->where('user_id', $leave_app->user_id)
            ->increment('initial_bal', $leave_app->paid_count);

            
        if($leave_app->unpaid_count != null ){
          $withoutpay_id = LeaveMast::where('without_pay', 1)
                            ->first()
                            ->id;
          //Decrement unpaid_count from initial_bal
          LeaveAllotment::where('leave_mast_id', $withoutpay_id)
              ->where('user_id', $leave_app->user_id)
              ->decrement('initial_bal', $leave_app->unpaid_count);
        }
        
      }else{
        LeaveAllotment::where('leave_mast_id', $leave_app->leave_type_id)
              ->where('user_id', $leave_app->user_id)
              ->decrement('initial_bal', $leave_app->count);
      }
      
      Storage::delete($leave_app->file_path);
      $leave_app->delete();

      return back()->with('success', 'Record deleted successfully');
    }

    public function showrequest(Request $request){

        $leave_req = LeaveApply::find($request->id);
        return view('employee.leaves.show', compact('leave_req'));
    }

  /*  
    public function show($id)
    {
        return view('employee.leaves.show');
    }
   
    public function apply_leaves($id){
      return view('employee.leaves.apply');
    }

    public function applyform(){

        $leave_type = LeaveMast::all();
        // return $leave_type;
        return view('employee.leaves.create');
    }
    
    public function edit( $id)
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

   public function emp_leave()
    {
        $leave_type = DB::table('leave_mast')->get();
        return view('employee.leaves.leave',compact('leave_type'));
    }
  */
}
