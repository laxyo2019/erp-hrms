<?php

namespace App\Models\payroll\settings;

use Illuminate\Database\Eloquent\Model;

class Chapt6Head extends Model
{
    protected $table = 'hrms_chapt6_section_head';

    protected $guarded = [];

    public function section(){
    	return $this->belongsTo('App\Models\Master\Chapt6Section', 'chapt6_section_id');
    }
}
