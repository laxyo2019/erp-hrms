<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeMast extends Model
{
	use SoftDeletes;
  protected $table = 'emp_mast';

  protected $fillable = ['id', 'parent_id', 'emp_code', 'comp_id', 'dept_id', 'desg_id', 'grade_id', 'emp_name', 'emp_img', 'emp_gender', 'emp_dob', 'curr_addr', 'perm_addr', 'blood_grp', 'contact', 'alt_contact', 'email', 'alt_email', 'driv_lic', 'aadhar_no', 'voter_id', 'pan_no', 'emp_type', 'emp_status', 'old_uan', 'curr_uan', 'old_pf', 'curr_pf', 'old_esi', 'curr_esi', 'join_dt', 'leave_dt','active'];

	public function company(){
 		return $this->belongsTo('App\Models\Master\CompMast','comp_id');
 	}

 	// public function tours(){
 	// 	return $this->hasMany('App\Models\Tours','emp_id');
 	// }

 	public function designation(){
 		return $this->belongsTo('App\Models\Master\Designation', 'desg_id');
 	}

 	public function grade(){
 		return $this->belongsTo('App\Models\Master\Grade','desg_id');
 	}

 	public function dobFormated($value)
  {
     return date("d-m-Y", strtotime($value));
  }
 	// public function user(){
 	// 	return $this->hasOne('App\User','id');
 	// }

 	// public function stages(){
 	// 	return $this->hasMany('App\Models\TourStages','emp_id');
 	// }

 	public function academics(){
 		return $this->hasMany('App\Models\Employees\EmpAcademic','emp_id');
 	}

 	public function experiences(){
 		return $this->hasMany('App\Models\Employees\EmpExp','emp_id');
 	}

 	public function documents(){
 		return $this->hasMany('App\Models\Employees\EmpDocument', 'emp_id');
 	}

 	public function bankdetails(){
 		return $this->hasMany('App\Models\Employees\EmpBankDetail', 'emp_id');
 	}

 	public function nominee(){
 		return $this->hasMany('App\Models\Employees\EmpNominee', 'emp_id');
 	}

 	public function leaveapplies(){
 		return $this->hasMany('App\Models\Employees\LeaveApply', 'emp_id');
 	}

 	public function department(){
 		return $this->belongsTo('App\Models\Master\DeptMast', 'dept_id');
 	}

 	public function allotments(){
 		return $this->hasMany('App\Models\Employees\LeaveAllotment', 'emp_id');
 	}

 	// public function approver_detail(){
 	// 	return $this->hasMany('App\Models\Employees\LeaveApply','id');
 	// }
 	public function UserName(){
 		return $this->hasOne('App\User', 'id');
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
 		return $this->belongsTo('App\Models\Employees\EmployeeMast','reports_to');
 	}

 	public function approve_name(){
      return $this->belongsTo('App\Models\Employees\EmployeeMast', 'approver_id','id');
  }

    		
}