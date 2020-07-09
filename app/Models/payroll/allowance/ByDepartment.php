<?php

namespace App\Models\payroll\allowance;

use Illuminate\Database\Eloquent\Model;

class ByDepartment extends Model
{
    protected $table = 'hrms_allowance_department';

    protected $guarded = [];

    public function welfare(){
    	return $this->belongsTo('App\Models\payroll\Welfare', 'welfare_id');
    }

    public function department(){
    	return $this->belongsTo('App\Models\Master\DeptMast', 'department_id');
    }
}
