<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Models\Master\Grade;
use App\Models\Master\EmpType;
use App\Models\Master\CompMast;
use App\Models\Master\DeptMast;
use App\Models\Master\EmpStatus;
use Illuminate\Support\Facades\DB;
use App\Models\Master\DocTypeMast;
use App\Models\Master\Designation;
use App\Models\Master\MaritalStatus;
use App\Models\Master\NomineeType;


class MasterController extends Controller
{
	public function __construct(){

		$this->middleware('auth');

	}

	public function start_page(){
			$tables = array(
				 	

				array(
						'table_name'	=> 'hrms_comp_mast',
						'display_name'	=> 'Companies',
						'icon'			=> 'fa fa-building-o',
						'bg_color'		=> '#ffc107',
						'count'			=> CompMast::count()
						),
			 	array(
						'table_name'	=> 'hrms_dept_mast',
						'display_name'	=> 'Departments',
						'icon'			=> 'fa fa-shekel',
						'bg_color'		=> '#dc3545',
						'count'			=> DeptMast::count()
						),
				array(
						'table_name'	=> 'hrms_marital_status',
						'display_name'	=> 'Marital Status',
						'icon'			=> 'fa fa-file-text',
						'bg_color'		=> '#ff7f07',
						'count'			=> MaritalStatus::count()
						),
				
				array(
						'table_name'	=> 'hrms_desg_mast',
						'display_name'	=> 'Employee Designations',
						'icon'			=> 'fa fa-id-card',
						'bg_color'		=> '#05f3d7db',
						'count'			=> Designation::count()
						),
				
				array(
						'table_name'	=> 'hrms_emp_grade_mast',
						'display_name'	=> 'Employee Grades',
						'icon'			=> 'fa fa-id-badge',
						'bg_color'		=> '#ef041a',
						'count'			=> Grade::count()
						),
			 	
				array(
						'table_name'	=> 'hrms_emp_status_mast',
						'display_name'	=> 'Employee Status',
						'icon'			=> 'fa fa-street-view',
						'bg_color'		=> '#3b35d2db',
						'count'			=> EmpStatus::count()
						),
				
				array(
						'table_name'	=> 'hrms_emp_type_mast',
						'display_name'	=> 'Employee Types',
						'icon'			=> 'fa fa-user-secret',
						'bg_color'		=> '#28a745',
						'count'			=> EmpType::count()
						),
				array(
						'table_name'	=> 'hrms_nominee_type',
						'display_name'	=> 'Nominee Types',
						'icon'			=> 'fa fa-user-secret',
						'bg_color'		=> '#28a745',
						'count'			=> NomineeType::count()
						),
/*
				array(
							'table_name'	=> 'leave_type_mast',
							'display_name'	=> 'Leave Type',
							'icon'			=> 'fa fa-users',
							'bg_color'		=> '#22615fa6',
							'count'			=> DB::table('leave_type_mast')->get()->count()
							),

				array(
				 			'table_name'	=> 'activity_mast',
							'display_name'	=> 'Activity',
							'icon'			=> 'fa fa-futbol-o',
							'bg_color'		=> '#17a2b8',
							'count'			=> DB::table('activity_mast')->get()->count()
						),
				
				array(
							'table_name'	=> 'tender_catg_mast',
							'display_name'	=> 'Tender Categories',
							'icon'			=> 'fa fa-cubes',
							'bg_color'		=> '#ff0064',
							'count'			=> DB::table('tender_catg_mast')->get()->count()
							),
				array(
							'table_name'	=> 'tender_type_mast',
							'display_name'	=> 'Tender Types',
							'icon'			=> 'fa fa-clone',
							'bg_color'		=> '#22615fa6',
							'count'			=> DB::table('tender_type_mast')->get()->count()
							),
				array(
							'table_name'	=> 'expense_catg_mast',
							'display_name'	=> 'Expense Categories',
							'icon'			=> 'fa fa-money',
							'bg_color'		=> '#d2335b',
							'count'			=> DB::table('expense_catg_mast')->where('deleted_at',null)->get()->count()
							),
				array(
							'table_name'	=> 'asset_mast',
							'display_name'	=> 'Assets',
							'icon'			=> 'fa fa-anchor',
							'bg_color'		=> '#ef06ac',
							'count'			=> DB::table('asset_mast')->get()->count()
							),

				array(
							'table_name'	=> 'emp_event_mast',
							'display_name'	=> 'Employee Events',
							'icon'			=> 'fa fa-line-chart',
							'bg_color'		=> '#3e4a56a6',
							'count'			=> DB::table('emp_event_mast')->get()->count()
							),

				array(
							'table_name'	=> 'expense_mode_mast',
							'display_name'	=> 'Expense Modes',
							'icon'			=> 'fa fa-modx',
							'bg_color'		=> '#17a2b8',
							'count'			=> DB::table('expense_mode_mast')->get()->count()
							),
				array(
							'table_name'	=> 'tender_client_mast',
							'display_name'	=> 'Tender Clients',
							'icon'			=> 'fa fa-user-plus',
							'bg_color'		=> '#c1c120',
							'count'			=> DB::table('tender_client_mast')->get()->count()
							),
							*/
				  
				);
			//sort array
			 $temp = '';
       for($i = 0; $i < count($tables); $i++)
	    	{
	    		for ($j = $i+1; $j < count($tables); $j++)
	    		{
	    			if(strtoupper($tables[$i]['display_name']) > strtoupper($tables[$j]['display_name']))
	    			{
	    				$temp = $tables[$i];
	    				$tables[$i] = $tables[$j];
	    				$tables[$j] = $temp;
	    			}
	    		}
	    	}
	    	//sort end
   		return  view('settings.mast_entity.index',compact('tables'));
	}
	public function fetch_name($tbl_name){
		$tables = array(
					'hrms_comp_mast'		=>	'Companies',
					'hrms_dept_mast'		=>	'Departments',
					'hrms_marital_status'	=>	'Marital Status',
					'hrms_emp_status_mast'	=> 	'Employee Status',
					'hrms_desg_mast'		=>  'Employee Designations',
					'hrms_emp_type_mast'	=>  'Employee Types',
					'hrms_emp_grade_mast'	=> 	'Employee Grades',
					'hrms_nominee_type'		=> 	'Nominee Types'
					/*'leave_type_mast'		=> 	'Leave Types',
				  	'acitvity_mast'			=> 	'Activities'
					'asset_mast'			=>	'Assets',
					'emp_event_mast'		=>  'Employee Events',
					'expense_catg_mast'		=>  'Expense Categories',
					'expense_mode_mast'		=>  'Expense Modes',
					'tender_catg_mast'		=> 	'Tender Categories',
					'tender_client_mast'	=> 	'Tender Clients',
					'tender_type_mast'		=> 	'Tender Types'*/
				);
		foreach($tables as $key => $val){
			if($key == $tbl_name){
				return $val;
				break;
			}
		}

	}
	
	public function index($db_table)
	{
		$table_name = $this->fetch_name($db_table);
		$data = DB::table($db_table)->where('deleted_at',null)->get();
		return view('settings.mast_entity.all', compact('data','table_name', 'db_table'));
	}

	public function createOrEditOrShow($method, $db_table, $id = null)
	{
		$table_name = $this->fetch_name($db_table);
		switch ($method) {
	    case "create":
	        return view('settings.mast_entity.create', compact('db_table','table_name'));
	        break;
	    case "edit":
	        $data = DB::table($db_table)->where('id', $id)->first();
					return view('settings.mast_entity.edit', compact('data', 'db_table','table_name'));
	        break;
	    case "show":
	        $data = DB::table($db_table)->where('id', $id)->first();
					return view('settings.mast_entity.show', compact('data', 'db_table','table_name'));
	        break;
	    default:
	        echo "Error";
		}
	}

	public function storeOrUpdate($method, $db_table, $id = null)
	{
		switch ($method) {
	    case "store":
		    $vdata = request()->validate([
					'name' 		  => 'required|unique:'.$db_table,
					'description' => 'nullable'
				]);
	      DB::table($db_table)
          ->insert(['name' => $vdata['name'], 'description' => $vdata['description']]);
        break;
	    case "update":
		    $vdata = request()->validate([
					'name' => 'required|unique:'.$db_table.',name,'.$id,
					'description' => 'nullable'
				]);
        DB::table($db_table)
            ->where('id', $id)
            ->update(['name' => $vdata['name'], 'description' => $vdata['description']]);
        break;
	    default:
	        echo "Error";
    }

    return redirect()->route('mast_entity.all',['db_table'=>$db_table]);    
	}

	public function destroy($db_table, $id)
	{
		$data = DB::table($db_table)->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s',time())]);
		return redirect()->route('mast_entity.all',['db_table'=>$db_table]);    
	}

}