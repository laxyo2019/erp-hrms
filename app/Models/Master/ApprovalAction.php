<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;


class ApprovalAction extends Model
{
    protected $table = 'approval_actions_mast';

    public function designations(){

    	return $this->belongsToMany('App\Models\Master\Designation', 'approval_designation');
    }
}
