<?php

namespace App\Models\issue;

use Illuminate\Database\Eloquent\Model;

class IndentRecord extends Model
{
    protected $table = 'hrms_indent_record';

    protected $guarded = [];

    public function employee(){
    	return $this->belongsTo('App\Models\Employees\EmployeeMast', 'user_id', 'user_id')->orderBy('emp_name', 'ASC');
    }

}
