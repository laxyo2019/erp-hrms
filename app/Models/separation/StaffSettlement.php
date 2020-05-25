<?php

namespace App\Models\separation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffSettlement extends Model
{
	use SoftDeletes;
	
    protected $table = 'hrms_staff_settlement';

    protected $guarded = [];


}
