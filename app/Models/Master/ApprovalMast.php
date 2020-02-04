<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalMast extends Model
{
  use SoftDeletes;
  protected $table = 'approval_mast';

  protected $with = ['designation'];

  protected $fillable = ['name', 'description'];
  
  public function approval()
  {
    return $this->hasMany('App\Models\ApprovalTemplate');
  }

  public function designation(){
  	return $this->belongsTo('App\Models\Master\Designation', 'desg_id');
  }
}
