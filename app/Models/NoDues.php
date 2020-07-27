<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoDues extends Model
{
    protected $table = 'hrms_nodues_request';
    protected $guarded = [];

    public function employee(){
    	return $this->belongsTo('App\Models\Employees\EmployeeMast', 'user_id', 'user_id');
    }

    public function department(){

    	return $this->belongsTo('App\Models\Master\DeptMast', 'department_id');
    }

    
}
