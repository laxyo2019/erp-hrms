<?php

namespace App\Models\separation;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class StaffSeparation extends Model
{
	use SoftDeletes;
	
    protected $table = 'hrms_separations';

    protected $guarded = [];

}
