<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Birthdays extends Model
{
    use SoftDeletes;

    protected $table = 'hrms_birthdays';
    protected $guarded = [];
}
