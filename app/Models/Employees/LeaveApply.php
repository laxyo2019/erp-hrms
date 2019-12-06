<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveApply extends Model
{
    use SoftDeletes;

    protected $table = 'emp_leave_applies';
    protected $with	 =	['approve_name', 'leavetype'];

    public function employee(){

        return $this->belongsTo('App\Models\Employees\EmployeeMast', 'emp_id');
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
    
    
}
