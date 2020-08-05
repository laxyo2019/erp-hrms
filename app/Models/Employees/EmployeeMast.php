<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeMast extends Model
{
	use SoftDeletes;

  protected $table = 'emp_mast';

  protected $guarded = [];

	public function company(){
 		return $this->belongsTo('App\Models\Master\CompMast','comp_id');
 	}

   public function branch(){
    return $this->belongsTo('App\Models\Employees\CompBranch', 'branch_id');
  }
 

 	public function designation(){
 		return $this->belongsTo('App\Models\Master\Designation', 'desg_id');
 	}

 	public function grade(){

 		return $this->belongsTo('App\Models\Master\Grade','grade_id');

 	}

 	public function dobFormated($value)
  {
     return date("d-m-Y", strtotime($value));
  }

 	public function academics(){
 		return $this->hasMany('App\Models\Employees\EmpAcademic','user_id', 'user_id');
 	}

 	public function experiences(){
 		return $this->hasMany('App\Models\Employees\EmpExp','user_id');
 	}

 	public function documents(){
 		return $this->hasMany('App\Models\Employees\EmpDocument', 'user_id', 'user_id');
 	}

 	public function bankdetails(){
 		return $this->hasMany('App\Models\Employees\EmpBankDetail', 'user_id');
 	}

 	public function nominee(){
 		return $this->hasMany('App\Models\Employees\EmpNominee', 'user_id', 'user_id');
 	}

  public function family(){
    return $this->hasMany('App\Models\Employees\Family', 'user_id', 'user_id');
  }

 	public function leaveapplies(){
 		return $this->hasMany('App\Models\Employees\LeaveApply', 'user_id');
 	}

 	public function department(){
 		return $this->belongsTo('App\Models\Master\DeptMast', 'dept_id');
 	}

 	public function allotments(){
 		return $this->hasMany('App\Models\Employees\LeaveAllotment', 'user_id', 'user_id');
 	}

 	public function UserName(){
 		return $this->hasOne('App\User', 'id', 'reports_to');
 	}

 	public function emptype(){
 		return $this->hasOne('App\Models\Master\EmpType', 'id','emp_type');
 	}

 	public function empstatus(){
 		return $this->hasOne('App\Models\Master\EmpStatus', 'id','emp_status');
 	}

 	public function empgrade(){
 		return $this->hasOne('App\Models\Master\Grade', 'id','grade_id');
 	}

 	public function empdesignation(){
 		return $this->hasOne('App\Models\Master\Designation', 'id','desig_id');
 	}
  
 	public function reportto(){
 		return $this->belongsTo('App\Models\Employees\EmployeeMast','reports_to', 'user_id');
 	}

 	public function approve_name(){
      return $this->belongsTo('App\Models\Employees\EmployeeMast', 'approver_id','id');
  }

  

    		
}