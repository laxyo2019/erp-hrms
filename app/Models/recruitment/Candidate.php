<?php

namespace App\Models\recruitment;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $table = 'recruit_candidates';

    protected $guarded = [];

    public function education(){
    	return $this->belongsTo('App\Models\Master\EduLevel', 'education_level');
    }
}
