<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class CompBranch extends Model
{
    //

    protected $table = 'hrms_comp_branch';
    protected $guarded = [];

    public function branch(){
    	return $this->belongsTo('App\Models\Master\CompMast', 'comp_id');
    }
}
