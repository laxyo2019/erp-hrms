<?php

namespace App\Http\Controllers\HRD;

use DB;
use Session;
use App\User;
use App\Models\Master\Grade;
use Illuminate\Http\Request;
use App\Models\Master\EmpType;
use App\Models\Master\CompMast;
use App\Models\Master\DeptMast;
use App\Models\Employees\EmpExp;
use App\Models\Master\EmpStatus;
use App\Models\Master\LeaveMast;
use App\Imports\EmployeesImport;
use App\Exports\EmployeesExport;
use App\Models\Master\Designation;
use App\Models\Master\DocTypeMast;
use App\Models\Employees\EmpNominee;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ErrorEmployeeExport;
use App\Http\Controllers\Controller;
use App\Models\Employees\EmpDocument;
use App\Models\Employees\EmpAcademic;
use App\Models\Employees\EmployeeMast;
use Illuminate\Support\Facades\Storage;
use App\Models\Employees\EmpBankDetail;
use App\Models\Employees\LeaveAllotment;



class EmployeesController extends Controller
{
 	public function __construct(){
    $this->middleware('auth');
  }

  public function index()
  {		

		$employees = EmployeeMast::with('company','grade','designation')->orderBy('id', 'DESC')->get();

    $leaves = LeaveMast::where('id','1')->get();
  
    return view('HRD.employees.index',compact('employees', 'leaves'));
  }

  /*
    public function insert_employee(Request $request){

  	$employee = new EmployeeMast();
  	$employee->emp_name = $request->name; //emp ID will updated in users
  	$employee->save();
  	return redirect()->route('employees.index')->with('success','Employee Created successfully');
    }
  */

  public function save_main(Request $request,$id){

	  $vdata = request()->validate([
			'name'     => 'required|max:50',
			'email'    => 'required|email|max:50',
			'contact'  => 'required|max:10|numeric',
		],[
			'contact.required' => 'The contact number field is required.',
			'contact.max'      => 'The contact number may not be greater than 10 digits.',
		]);
    
		$employee = EmployeeMast::findOrfail($id);
		$employee->emp_name = $vdata['name'];
		$employee->email    = $vdata['email'];
		$employee->contact  = $vdata['contact'];
		$employee->save();
    
		return redirect()->route('employee.show_page',['id'=>$id,'tab'=>'main'])->with('success','Updated successfully.');
  }

  public function save_personal(Request $request, $user_id){

    //return $user_id;
    $vdata = request()->validate([
      'full_name'      => 'required|max:45',
      'contact_number' => 'nullable|numeric',
      'alternate_contact_number' => 'nullable|numeric',
      'email'          => 'nullable|email|max:50',
      'alternate_email'=> 'nullable|email|max:50',
    ]);

    /*** Directory structure ***/

    if($request->hasFile('file_path')){
      $dir      = 'hrms_uploads/'.date("Y").'/'.date("F");
      $file_ext = $request->file('file_path')->extension();
      $filename = $id.'_'.time().'_personal.'.$file_ext;
      $path     = $request->file('file_path')->storeAs($dir, $filename);
    }else{
      $path = 'emp_default_image.png';
    }

    EmployeeMast::where('user_id', $user_id)
      ->update([
        'emp_name'   => $vdata['full_name'],
        'emp_gender' => $request->emp_gender,
        'emp_dob'    => $request->emp_dob,
        'blood_grp'  => $request->blood_group,
        'curr_addr'  => $request->curr_addr,
        'perm_addr'  => $request->perm_addr,
        'contact'    => $vdata['contact_number'],
        'alt_contact'=> $vdata['alternate_contact_number'],
        'email'      => $vdata['email'],
        'alt_email'  => $vdata['alternate_email'],
        'driv_lic'   => $request->drive_lic
      ]);

    User::findOrfail($user_id)
      ->update([
        'name' => $vdata['full_name']
      ]);

    return redirect()->route('employee.show_page',['id'=>$user_id,'tab'=>'personal'])->with('success','Updated successfully.');
  }

  public function save_official(Request $request,$user_id){
      
    $vdata = request()->validate([

      'aadhar_no' => 'string|nullable|max:20',
      'pan_no'    => 'string|nullable|max:20',
      'voter_id'  => 'string|nullable|max:20',
      'old_pf'    => 'string|nullable|max:20',
      'new_pf'    => 'string|nullable|max:20',
      'driv_lic'  => 'string|nullable|max:20',
      'old_uan'   => 'string|nullable|max:20',
      'curr_uan'  => 'string|nullable|max:20',
      'old_esi'   => 'string|nullable|max:20',
      'curr_esi'  => 'string|nullable|max:20',
    ]);
    // return EmployeeMast::where('user_id',$user_id)->get();

    $employee = EmployeeMast::where('user_id', $user_id)
      ->update([
        'comp_id'    => $request->comp_id,
        'dept_id'    => $request->dept_id,
        'emp_type'   => $request->emp_type,
        'reports_to' => $request->reports_to,
        'emp_status' => $request->emp_status,
        'join_dt'    => $request->join_dt,
        'leave_dt'   => $request->leave_date,
        'emp_code'   => $request->emp_code,
        'grade_id'   => $request->emp_grade,
        'desg_id'    => $request->designation,
        'aadhar_no'  => $request->aadhar_no,
        'pan_no'     => $request->pan_no,
        'voter_id'   => $request->voter_id,
        'driv_lic'   => $request->driv_lic,
        'old_pf'     => $request->old_pf,
        'curr_pf'    => $request->new_pf,
        'old_uan'    => $request->old_uan,
        'curr_uan'   => $request->curr_uan,
        'old_esi'    => $request->old_esi,
        'curr_esi'   => $request->curr_esi,
      ]);
      // return $employee;
    return redirect()->route('employee.show_page',['user_id'=>$user_id,'tab'=>'official'])->with('success','Updated successfully.');
  }

  public function save_academics(Request $request, $user_id){

	  $vdata = request()->validate([
			'domain_of_study'    => 'max:90',
			'board_name'         => 'string|nullable|max:90',
			'year_of_completion' => 'string|nullable|max:4',
			'grade_or_percent'   => 'string|nullable|max:10',
		]);

    //Directory structure

    if($request->hasFile('file_path')){

      $dir      = 'hrms_uploads/'.date("Y").'/'.date("F");
      $file_ext = $request->file('file_path')->extension();
      $filename = $user_id.'_'.time().'_academic.'.$file_ext;
      $path     = $request->file('file_path')->storeAs($dir, $filename);

    }else{

      $path = null;

    }

		$employee = new EmpAcademic();
		$employee->user_id           = $user_id;
		$employee->domain_of_study   = $vdata['domain_of_study'];
		$employee->name_of_unversity = $vdata['board_name'];
		$employee->completed_in_year = $vdata['year_of_completion'];
		$employee->grade_or_pct      = $vdata['grade_or_percent'];
    $employee->file_path         = $path;
		$employee->note              = $request->special_note;
		$employee->save();

		return back()->with('success','Updated successfully.');
  }

  public function save_experience(Request $request,$user_id){

	  $vdata = request()->validate([
			'company_name' => 'required|max:100',
			'job_type'     => 'max:50',
			'designation'  => 'nullable|max:50',
			'comp_loc'     => 'nullable|max:50',
			'comp_email'   => 'email|nullable|max:100',
			'comp_website' => 'nullable|max:100',
			'monthly_ctc'  => 'nullable|max:11|regex:/^\d{0,6}(\.\d{1,2})?$/'
		]);

    if($request->hasFile('file_path')){

      $dir      = 'hrms_uploads/'.date("Y").'/'.date("F");
      $file_ext = $request->file('file_path')->extension();
      $filename = $user_id.'_'.time().'_experience.'.$file_ext;
      $path     = $request->file('file_path')->storeAs($dir, $filename);
    }else{
      $path = null;
    }

		$academic = new EmpExp();
		$academic->user_id          = $user_id;
		$academic->comp_name        = $vdata['company_name'];
		$academic->job_type         = $vdata['job_type'];
		$academic->monthly_ctc      = $vdata['monthly_ctc'];
		$academic->desg             = $vdata['designation'];
		$academic->comp_loc         = $vdata['comp_loc'];
		$academic->comp_email       = $vdata['comp_email'];
		$academic->comp_website     = $vdata['comp_website'];
		$academic->start_dt         = $request->start_date;
		$academic->end_dt           = $request->end_date;
		$academic->reason_of_leaving= $request->reason_of_leaving;
    $academic->file_path        = $path;
		$academic->save();

		return back()->with('success','Updated successfully.');
  }

  
  
  public function save_documents(Request $request, $user_id)
  {
    $vdata = request()->validate([
      'doc_title' => 'required',
      'file_path' => 'required|max:5120',
      'doc_status'=> 'max:1',
      'remarks'   => 'string|nullable'
    ]);

    if($request->file('file_path')){
        $doc_title= DB::table('doc_type_mast')->where('id', $vdata['doc_title'])->first();
    		$dir      = 'hrms_uploads/'.date("Y").'/'.date("F");
    		$title    = str_replace(' ', '_', $doc_title->name);
    		$file_ext = $request->file('file_path')->extension();
    		$filename = $user_id.'_'.time().'_'.$title.'.'.$file_ext;
    		$path     = $request->file('file_path')->storeAs($dir, $filename);
    }else{
      $path = null;
    }

    $document = new EmpDocument;
    $document->user_id       = $user_id;
    $document->doc_type_id  = $vdata['doc_title'];
    $document->file_path    = $path;
    $document->doc_status   = $vdata['doc_status'];
    $document->remarks       = $request->remarks;
    $document->date         = date('Y-m-d', time());
    $document->save();
    
    return redirect()->route('employee.show_page',['user_id'=>$user_id,'tab'=>'documents'])->with('success', 'Updated successfully.');
  }

  public function save_nominee(Request $request, $user_id){

    //return $user_id;
    $vdata = request()->validate([
      'nominee_name'  => 'required',
      'email'         => 'nullable|email',
      'aadhaar_no'    => 'required|max:20',
      'contact'       => 'nullable|numeric',
      'relation'      => 'nullable',
    ]);

    if($request->file('file_path')){      
      $dir = 'hrms_uploads/'.date("Y").'/'.date("F");
      $file_ext = $request->file('file_path')->extension();
      $filename = $user_id.'_'.time().'_nominee.'.$file_ext;
      $path = $request->file('file_path')->storeAs($dir, $filename);
    }else{

      $path = null;
    }

    $nominee = new EmpNominee;
    $nominee->user_id   = $user_id;
    $nominee->name      = $vdata['nominee_name'];
    $nominee->email     = $vdata['email'];
    $nominee->aadhar_no = $vdata['aadhaar_no'];
    $nominee->contact   = $vdata['contact'];
    $nominee->addr      = $request->address;
    $nominee->file_path = $path;
    $nominee->relation  = $vdata['relation'];
    $nominee->save();

    return back()->with('success', 'Updated successfully.');
  }

  public function save_bankdetails(Request $request, $user_id){

    $vdata = request()->validate([
      'acc_holder'=> 'required',
      'acc_no'    => 'required',
      'bank_name' => 'required',
      'ifsc'      => 'required',
      'note'      => 'nullable|string'
      ],
      [
        'acc_holder.required' => 'Account holder name is required.',
        'acc_no.required'     => 'Account no is required',
        'bank_name.required'  => 'Bank name is required',
        'ifsc.required'       => 'IFSC code is required',
        'branch.required'     => 'Branch name is required',
      ]);

    //User input
    $is_primary = $request->is_primary; 

    if(empty($is_primary)){

      $is_primary = 0;

    }

    if($request->file('file_path')){
      $dir = 'hrms_uploads/'.date("Y").'/'.date("F");
      $file_ext = $request->file('file_path')->extension();
      $filename = $user_id.'_'.time().'_bank_detail.'.$file_ext;
      $path = $request->file('file_path')->storeAs($dir, $filename);
    }else{

      $path = null;
    }

    $bankdetails              = new EmpBankDetail;
    $bankdetails->user_id     = $user_id;
    $bankdetails->acc_holder  = $vdata['acc_holder'];
    $bankdetails->acc_no      = $vdata['acc_no'];
    $bankdetails->bank_name   = $vdata['bank_name'];
    $bankdetails->ifsc        = $vdata['ifsc'];
    $bankdetails->branch_name = $request->branch;
    $bankdetails->file_path   = $path;
    $bankdetails->is_primary  = $is_primary;
    $bankdetails->note        = $vdata['note'];
    $bankdetails->save();

    return back()->with('success', 'Updated successfully.');
  }
  /*
    Toggle sections on employee detail page
  */

  public function show_page($user_id, $tab)
  {
  	$meta      = array();
    $employee  = EmployeeMast::where('user_id', $user_id)->first();
    $path      = "HRD.employees.details.".$tab;

    if($tab == 'official'){

    	$meta['emp_types']     = EmpType::where('deleted_at', null)->get();
    	$meta['emp_statuses']  = EmpStatus::where('deleted_at', null)->get();
      $meta['comp_mast']     = CompMast::where('deleted_at', null)->get();
      $meta['dept_mast']     = DeptMast::where('deleted_at', null)->get();
      $meta['grade_mast']    = Grade::all();
      $meta['designation']   = Designation::where('deleted_at', null)->get();
      $meta['emp_mast']      = EmployeeMast::where('deleted_at', null)->get();
    }

    if($tab == 'academics'){

      $employee = EmployeeMast::with('academics')
                ->where('user_id', $user_id)
                ->first();

    }

    if($tab == 'experience'){

    	$employee = EmployeeMast::with('experiences')->where('user_id',$user_id)->first();
    }

    if($tab == 'documents'){

      $meta['doc_types'] = DocTypeMast::all();

      $employee = EmployeeMast::with('documents')
                    ->where('user_id',$user_id)
                    ->first();
    }

    if($tab == 'nominee'){

      $employee = EmployeeMast::with('nominee')
                    ->where('user_id',$user_id)
                    ->first();
    }
    // return "hello";

    return view($path,compact('employee','meta'));
  }

/*Created by kishan developer*/
public function viewDetails($user_id, $view)
  {
    $meta      = array();
    $employee  = EmployeeMast::where('user_id', $user_id)->first();
    $path      = "HRD.employees.view-details.".$view;

    if($view == 'official'){
      
      $meta['emp_types']     = EmpType::where('deleted_at', null)->get();
      $meta['emp_statuses']  = EmpStatus::where('deleted_at', null)->get();
      $meta['comp_mast']     = CompMast::where('deleted_at', null)->get();
      $meta['dept_mast']     = DeptMast::where('deleted_at', null)->get();
      $meta['grade_mast']    = Grade::all();
      $meta['designation']   = Designation::where('deleted_at', null)->get();

      $meta      = EmployeeMast::with('company','designation','grade','academics','experiences','documents','department','emptype','empstatus','empgrade','empdesignation','reportto')->where('deleted_at', null)->where('user_id',$user_id)->first(); 
    }

    if($view == 'academics'){
      $employee = EmployeeMast::with('academics')->where('user_id',$user_id)->first();
    }

    if($view == 'experience'){

      $employee = EmployeeMast::with('experiences')->where('user_id',$user_id)->first();
    }

    if($view == 'documents'){

      $meta['doc_types'] = DocTypeMast::all();
      $employee = EmployeeMast::with('documents')->where('user_id',$user_id)->first();
     
    }

    if($view == 'nominee'){
       $employee = EmployeeMast::with('nominee')->where('user_id',$user_id)->first();
    }

    return view($path,compact('employee','meta'));
  }

/*end Created by kishan developer*/

  public function edit($id)
  {
    $data['employee']     = EmployeeMast::with('company','designation')->findOrFail($id);
	  $data['reports_to']   = EmployeeMast::all();
    $data['grades']       = Grade::all();
		$data['designations'] = Designation::all();
    //return $data['reports_to'];
    
    return view('HRD.employees.edit',compact('data'));
  }

  public function update(Request $request, $id)
  {	
  	$vdata =  $request->validate([
			'name'       => 'required|string|max:50',
 			'emp_code'   => 'nullable|string|max:15',
 			'emp_gender' => 'nullable',
 			'emp_dob'    => 'nullable',
 			'join_dt'    => 'required',
 			'emp_desg'   => 'nullable',
			],[
				'emp_dob.required'  => 'The Date of Birth is requred.',
				'join_dt.required'  => 'The Joining date is requred.',
				/*'emp_desg.required' => 'The Designation is requred.',*/
			]);

    $employee = EmployeeMast::findOrfail($id);
    $employee->emp_name   = $vdata['name']/*." ".$vdata['full_name']*/;
    $employee->emp_code   = $vdata['emp_code'];
    $employee->reports_to = $request->reports_to;
    $employee->grade_id   = $request->grade_id;
    $employee->emp_gender = $request->emp_gender;
    $employee->emp_dob    = $request->emp_dob;
    $employee->join_dt    = $request->join_dt;
    $employee->desg_id    = $request->emp_desg;
    $employee->save();

    return back()->with('success','Updated successfully.');
  }  

  public function store(Request $request)
  {
      
  }

  public function getForm(Request $request, $type)
  {
  	$data['employee'] = EmployeeMast::findOrFail($request->emp_id);
    return view('HRD.employees.forms.'.$type,$data);
  }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function edit($id)
    {
       $data['employee'] = EmployeeMast::with('company','designation')->findOrFail($id);
  			$data['parent_ids'] = EmployeeMast::where('comp_id',$data['employee']->comp_id)->where('id','!=',$data['employee']->id)->get();
  			 $data['grades'] = Grade::all();
  			$data['designations'] = Designation::all();
        return view('HRD.employees.edit',$data);
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function update(Request $request, $id)
    {	
    	$data =  $request->validate([
    						'name'	=> 'required|string|max:50',
				   			'emp_code'	=> 'required|string|max:15',
				   			'emp_gender'	=> 'required',
				   			'emp_dob'	=> 'required',
				   			'join_dt'	=> 'required',
				   			'emp_desg'	=> 'required',
	    					],[
	    						'emp_dob.required' => 'The Date of Birth is requred.',
	    						'join_dt.required' => 'The Joining date is requred.',
	    						'emp_desg.required' => 'The Designation is requred.',
	    					]);
    	 $employee = EmployeeMast::find($id);
       $employee->emp_name = trim($data['name']);
       $employee->emp_code = $data['emp_code'];
       $employee->emp_gender = $data['emp_gender'];
       $employee->grade_id = $request->grade_id;
       $employee->emp_dob = $data['emp_dob'];
       $employee->join_dt = $data['join_dt'];
       $employee->desg_id = $data['emp_desg'];
       $employee->parent_id = $request->parent_id;
       $employee->save();
	   	return redirect()->route('employees.index')->with('success','Employee details Updated Successfully');
    }
*/
  public function fetch_designation(Request $request){
  		$designations = Designation::where('comp_id',$request->comp_id)->get();
  		return $designations;

  }


  public function delete_row($db_table, $id){

    if($db_table == 'hrms_emp_academics'){
      $academic = EmpAcademic::find($id);
      $academic->delete();
      Storage::delete($academic->file_path);
    }

    if($db_table == 'hrms_emp_exp'){
      $experience = EmpExp::find($id);
      $experience->delete();
      Storage::delete($experience->file_path);
    }
    if($db_table == 'hrms_emp_nominee'){


      $nominee = EmpNominee::find($id);
      $nominee->delete();
      Storage::delete($nominee->file_path);
    }
    if($db_table == 'hrms_emp_bank_details'){
      $bankdetails = EmpBankDetail::find($id);
      $bankdetails->delete();
      Storage::delete($bankdetails->file_path);
    }
    if($db_table == 'hrms_emp_docs'){

      $documents = EmpDocument::find($id);
      $documents->delete();
      Storage::delete($documents->file_path);
    }
    
    return back()->with('success','Status deleted successfully.');
  }

  //Employees Export
  public function export(){

    return Excel::download(new EmployeesExport, 'employee.xlsx');      
  }

  public function save_session(Request $request){
      
    $user_ids = $request->user_id;

    Session::put('user_ids',$user_ids);
  }

  public function activeInactive(Request $request){

   return EmployeeMast::where('id',$request->id)->update(array('active' => '0'));
  }

  //Employees Import

  public function import(Request $request){

   $this->validate($request, [
          'import' => 'required'
          ]);

    $records = Excel::toCollection(new EmployeesImport, $request->file('import'));

    $status = TRUE;
    $error  = [];

    foreach( $records as $record ){

      foreach( $record as $data ){

        //if($status == TRUE){

          if($data['id'] == ''){

            $status = FALSE;

          }else{
            
            if($data['emp_name'] == ''){

               $status = FALSE;
               
             }else{

               $status = TRUE;
             }

          }
          //return ([$status]);
        //}
        
/*
        if($status == TRUE){

          if($data['emp_name'] == ''){

            $status = FALSE;
            
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['emp_img'] == ''){

            $status = TRUE;
            $data['emp_img'] = null;
          }else{

            $status = TRUE;
          }
        }*/
/*
        if($status == TRUE){

          if($data['email'] == ''){

            $status = TRUE;
            $data['email'] = null;
          }else{

            $status = TRUE;
          }
        }


   
         if($status == TRUE){

          if($data['parent_id'] == '' ){

            $status = TRUE;
            $data['parent_id'] = null;

          }else{
            $status = TRUE;

          }
         }

        if($status == TRUE){

          if($data['emp_code'] == ''){

            $status = TRUE;
            $data['emp_code'] = null;

          }else{

            $status = TRUE;

          }
        }

        if($status == TRUE){

          if($data['comp_id'] == ''){
            $status = TRUE;
            $data['comp_id'] = null;

          }else{

            $status = TRUE;

          }
        }
        if($status = TRUE){

          if($data['dept_id'] == ''){

            $status = TRUE;
            $data['dept_id'] = null;

          }else{

            $status = TRUE;

          }
        }

        if($status == TRUE){

          if($data['desg_id'] == ''){

            $status = FALSE;
          }else{

            $status = TRUE;
          }
        }
        if($status == TRUE){

          if($data['grade_id'] == ''){

            $status = TRUE;
            $data['grade_id'] = null;

          }else{

            $status = TRUE;
          }
        }
        if($status == TRUE){

          if($data['emp_gender'] == ''){

            $status = TRUE;
            $data['emp_gender'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['emp_dob'] == ''){

            $status = TRUE;
            $data['emp_dob'] = null;
          }else{
            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['curr_addr'] == ''){

            $status = TRUE;
            $data['curr_addr'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['perm_addr'] == ''){

            $status = TRUE;
            $data['perm_addr'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['blood_grp'] == ''){

            $status = TRUE;
            $data['blood_grp'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['contact'] == ''){

            $status = TRUE;
            $data['contact'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['alt_contact'] == ''){

            $status = TRUE;
            $data['alt_contact'] = null;
          }else{

            $status = TRUE;
          }
        }

        

        if($status == TRUE){

          if($data['alt_email'] == ''){

            $status = TRUE;
            $data['alt_email'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['driv_lic'] == ''){

            $status = TRUE;
            $data['driv_lic'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['aadhar_no'] == ''){

            $status = TRUE;
            $data['aadhar_no'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['voter_id'] == ''){

            $status = TRUE;
            $data['voter_id'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['pan_no'] == ''){

            $status = TRUE;
            $data['pan_no'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['emp_type'] == ''){

            $status = TRUE;
            $data['emp_type'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['emp_status'] == ''){

            $status = TRUE;
            $data['emp_status'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['old_uan'] == ''){

            $status = TRUE;
            $data['old_uan'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['curr_uan'] == ''){

            $status = TRUE;
            $data['curr_uan'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['old_pf'] == ''){

            $status = TRUE;
            $data['old_pf'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['curr_pf'] == ''){

            $status = TRUE;
            $data['curr_pf'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['old_esi'] == ''){

            $status = TRUE;
            $data['old_esi'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['curr_esi'] == ''){

            $status = TRUE;
            $data['curr_esi'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['join_dt'] == ''){

            $status = TRUE;
            $data['join_dt'] = null;
          }else{

            $status = TRUE;
          }
        }

        if($status == TRUE){

          if($data['leave_dt'] == ''){

            $status = TRUE;
            $data['leave_dt'] = null;
          }else{

            $status = TRUE;
          }
        }
*/
        if($status == TRUE){
          
         $data = $this->array_data($data);

         $emp = EmployeeMast::find($data['id']);

         if(!empty($emp)){

            EmployeeMast::where('id', $emp['id'])
              ->update($data);

         }else{
            // EmployeeMast::create($data);
         }

        }else if($status == FALSE){
          
          $error[] = $this->array_data($data);

          //return ([$error]);
        
        }
       
        $status = TRUE;

      }
    }

    if(count($error) != 0){

      return Excel::download(new ErrorEmployeeExport($error), 'erroremployeeexport.xlsx');
    }

    return back()->with('success', 'Data imported successfully.');

  }

  public function destroy($id)
  {
    $employee = EmployeeMast::find($id);
    $employee->delete();
		$employees = EmployeeMast::all();
    return view('HRD.employees.index',compact('employees'));
  }

  public function deleteEmp_detail(Request $request, $id)
  {
    DB::table($request->db_table)->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s',time())]);
    return redirect()->route('employee.show_page');    
  }

  public function downloadDocs($db_table, $id){

    $docs = DB::table($db_table)
      ->where('id', $id)
      ->first();

    return Storage::download('/'.$docs->file_path);
  }
  public function exp_table(Request $request){
    $exp = DB::table('emp_exp')
                ->where('id', $request->exp_id)
                ->first();
   return view('HRD.employees.details.exp_table',compact('exp'));
    
  }

  public function array_data($data){
    return $data = [
                    'id'         => $data['id'],
                    // 'reports_to'  => $data['reports_to'],
                    'emp_code'   => $data['emp_code'],
                    // 'comp_id'    => $data['comp_id'],
                    // 'dept_id'    => $data['dept_id'],
                    // 'desg_id'    => $data['desg_id'],
                    // 'grade_id'   => $data['grade_id'],
                    'emp_name'   => $data['emp_name'],
                    //'emp_img'    => $data['emp_img'],
                    //'emp_gender' => $data['emp_gender'],
                    'emp_dob'    => $data['emp_dob'],
                    'curr_addr'  => $data['curr_addr'],
                    'perm_addr'  => $data['perm_addr'],
                    //'blood_grp'  => $data['blood_grp'],
                    'contact'    => $data['contact'],
                    'alt_contact'=> $data['alt_contact'],
                    //'email'      => $data['email'],
                    'alt_email'  => $data['alt_email'],
                    'driv_lic'   => $data['driv_lic'],
                    'aadhar_no'  => $data['aadhar_no'],
                    'voter_id'   => $data['voter_id'],
                    'pan_no'     => $data['pan_no'],
                    //'emp_type'   => $data['emp_type'],
                    //'emp_status' => $data['emp_status'],
                    'old_uan'    => $data['old_uan'],
                    'curr_uan'   => $data['curr_uan'],
                    'old_pf'     => $data['old_pf'],
                    'curr_pf'    => $data['curr_pf'],
                    'old_esi'    => $data['old_esi'],
                    'curr_esi'   => $data['curr_esi'],
                    'join_dt'    => $data['join_dt'],
                    //'leave_dt'   => $data['leave_dt'],
                    //'active'     => $data['active'],
                  ];
  }
}
