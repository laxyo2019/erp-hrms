<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
	protected $table = 'hrms_holidays';
	protected $fillable = ['id', 'title', 'date', 'desc'];
    
}
