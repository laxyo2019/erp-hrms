<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveApply extends Model
{
    use SoftDeletes;

    protected $table = 'emp_leave_applies';
    //protected $with =	['approve_name', 'leavetype', 'employee']; //It will be called everytime when LeaveApply model is used.

    public function employee(){

        return $this->belongsTo('App\Models\Employees\EmployeeMast', 'user_id');
    }

    public function leavetype(){
        return $this->belongsTo('App\Models\Master\LeaveMast', 'leave_type_id');
    }

    public function approvalaction(){
        return $this->belongsTo('App\Models\Master\ApprovalAction', 'status');
    }
    
    public function approve_name(){
        return $this->belongsTo('App\Models\Employees\EmployeeMast', 'approver_id');
    }
    
    public function reportsto(){

        return $this->belongsTo('App\Models\Employees\EmployeeMast', 'reports_to');
    }

    public function approvaldetail(){
        return $this->hasOne('App\Models\Employees\LeaveApprovalDetail', 'leave_apply_id');
    }
}
