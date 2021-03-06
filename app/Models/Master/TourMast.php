<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourMast extends Model
{
  use SoftDeletes;
  protected $table = 'tour_mast';

  public function employee(){
 		return $this->belongsTo('App\Models\EmployeeMast','emp_id');
 	}

 	public function company(){
 		return $this->belongsTo('App\Models\CompMast','comp_code');
 	}

 	public function activity(){
 		return $this->belongsTo('App\Models\Activity');
 	}

 	public function stages(){
 		return $this->hasMany('App\Models\TourStages','tour_id');
 	}

 	public function current_stage_info(){
 		return $this->belongsTo('App\Models\ApprovalDetail','current_stage','id');
 	}
}
