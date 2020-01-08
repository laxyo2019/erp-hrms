<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class EmpLeave extends Model
{
	use SoftDeletes;
    protected $table = 'leave_mast';

    protected $fillable = ['name', 'leave_mast_id', 'total', 'generates_after', 'max_apply_once', 'min_apply_once', 'max_days_month', 'max_apply_month', 'max_apply_year', 'carry_forward'];
}
