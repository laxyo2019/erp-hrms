<?php

namespace App\Models\payroll\allowance;

use Illuminate\Database\Eloquent\Model;

class ByCadre extends Model
{
    protected $table = 'hrms_allowance_cadre';

    protected $guarded = [];

    public function welfare(){
    	return $this->belongsTo('App\Models\payroll\Welfare', 'welfare_id');
    }

    public function cadre(){
    	return $this->belongsTo('App\Models\Master\Cadre', 'cadre_id');
    }
}
