<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpDocument extends Model
{
    use SoftDeletes;

    protected $table = 'hrms_emp_docs';
    

}
