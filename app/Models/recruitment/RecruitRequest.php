<?php

namespace App\Models\recruitment;

use Illuminate\Database\Eloquent\Model;

class RecruitRequest extends Model
{
    protected $table = "recruitment_requests";
    
    protected $guarded = [];

    public function company(){
    	return $this->belongsTo('App\Models\Master\CompMast', 'comp_id');
    }

    public function employee(){
        return $this->belongsTo('App\Models\Employees\EmployeeMast', 'requested_by');
    }    

    public function department(){
    	return $this->belongsTo('App\Models\Master\DeptMast', 'depart_id');
    }

    public function employement(){
    	return $this->belongsTo('App\Models\Master\EmployementType', 'employement_type_id');
    }

    public function experience(){
    	return $this->belongsTo('App\Models\Master\ExpLevel', 'experience_level_id');
    }

    public function education(){
    	return $this->belongsTo('App\Models\Master\EduLevel', 'education_level_id');
    }


}
