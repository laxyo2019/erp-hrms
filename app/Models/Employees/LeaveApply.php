<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveApply extends Model
{
    use SoftDeletes;

    protected $table = 'hrms_emp_leave_applies';
    //protected $with =	['approve_name', 'leavetype', 'employee']; //It will be called everytime when LeaveApply model is used.
    protected $fillable = ['user_id', 'reports_to', 'leave_type_id', 'day_status', 'from', 'to', 'count', 'reason', 'file_path', 'addr_during_leave', 'contact_no', 'subadmin_approval', 'admin_approval', 'applicant_remark', 'approver_remark', 'hr_remark', 'carry', 'paid_count', 'unpaid_count'];

    public function employee(){

        return $this->belongsTo('App\Models\Employees\EmployeeMast', 'user_id', 'user_id');
    }

    public function leavetype(){
        return $this->belongsTo('App\Models\Master\LeaveMast', 'leave_type_id');
    }
    
    public function approve_name(){
        return $this->belongsTo('App\Models\Employees\EmployeeMast', 'approver_id', 'user_id');
    }
    
    public function reportsto(){

        return $this->belongsTo('App\Models\Employees\EmployeeMast', 'reports_to');
    }

    public function approvaldetail(){
        return $this->hasOne('App\Models\Employees\LeaveApprovalDetail', 'leave_apply_id');
    }
}
