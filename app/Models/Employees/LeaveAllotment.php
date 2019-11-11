<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class LeaveAllotment extends Model
{
    use SoftDeletes;
    
    protected $table = 'emp_leave_allotment';
}
