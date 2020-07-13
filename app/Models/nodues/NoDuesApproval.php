<?php

namespace App\Models\nodues;

use Illuminate\Database\Eloquent\Model;

class NoDuesApproval extends Model
{
    protected $table = 'hrms_nodues_approval';

    protected $guarded = [];

    public function employee(){
    	return $this->belongsTo('App\Models\Employees\EmployeeMast', 'hod_user_id', 'user_id');
    }

    public function department(){
    	return $this->belongsTo('App\Models\Master\DeptMast', 'hod_depart_id');
    }

}
