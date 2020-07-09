<?php

namespace App\Models\payroll\allowance;

use Illuminate\Database\Eloquent\Model;

class ByDesignation extends Model
{
    protected $table = 'hrms_allowance_designation';

    protected $guarded = [];

    public function welfare(){
    	return $this->belongsTo('App\Models\payroll\Welfare', 'welfare_id');
    }

    public function designation(){
    	return $this->belongsTo('App\Models\Master\Designation', 'designation_id');
    }
}
