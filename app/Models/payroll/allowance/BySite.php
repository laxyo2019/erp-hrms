<?php

namespace App\Models\payroll\allowance;

use Illuminate\Database\Eloquent\Model;

class BySite extends Model
{
    protected $table = 'hrms_allowance_site';

    protected $guarded = [];

    public function welfare(){
    	return $this->belongsTo('App\Models\payroll\Welfare', 'welfare_id');
    }

    public function site(){
    	return $this->belongsTo('App\Models\Master\Site', 'site_id');
    }
}
