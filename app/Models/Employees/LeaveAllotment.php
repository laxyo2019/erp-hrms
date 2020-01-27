<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class LeaveAllotment extends Model
{
    //use SoftDeletes;
    
    protected $table = 'emp_leave_allotment';

    public function employees(){
    	return $this->belongsTo('App\Models\Employees\EmployeeMast','user_id');
    }

    public function leaves(){
    	return $this->belongsTo('App\Models\Master\LeaveMast','leave_mast_id');
    }
}
