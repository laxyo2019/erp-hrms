<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Family extends Model
{
	use SoftDeletes;
	
    protected $table = 'hrms_family_details';
    protected $guarded = [];
}
