<?php

namespace App\Models\payroll;

use Illuminate\Database\Eloquent\Model;

class Chapt6Exemption extends Model
{
    protected $table   = 'hrms_chapt6_exemptions';

    protected $guarded = [];

    public function section(){
    	return $this->belongsTo('App\Models\Master\Chapt6Section', 'chapt6_section_id');
    }

    public function head(){
    	return $this->belongsTo('App\Models\payroll\settings\Chapt6Head', 'chapt6_head_id');
    }

    public function employee(){
    	return $this->belongsTo('App\Models\Employees\EmployeeMast', 'user_id', 'user_id');
    }
}
