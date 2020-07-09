<?php

namespace App\Models\payroll\allowance;

use Illuminate\Database\Eloquent\Model;

class ByEmployee extends Model
{
    protected $table = 'hrms_allowance_employee';

    protected $guarded = [];

    public function welfare(){
    	return $this->belongsTo('App\Models\payroll\Welfare', 'welfare_id');
    }

    public function employee(){
    	return $this->belongsTo('App\Models\Employees\EmployeeMast', 'employee_id', 'user_id');
    }
}
