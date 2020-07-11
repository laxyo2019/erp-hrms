<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class Hod extends Model
{
    protected $table = 'hrms_hod';
    protected $guarded = [];

    public function employee(){
    	return $this->belongsTo('App\Models\Employees\EmployeeMast', 'user_id', 'user_id');
    }

    public function department(){
    	return $this->belongsTo('App\Models\Master\DeptMast', 'depart_id')->orderBy('name','ASC');
    }
}
