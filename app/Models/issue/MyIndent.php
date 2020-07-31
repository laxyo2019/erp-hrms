<?php

namespace App\Models\issue;

use Illuminate\Database\Eloquent\Model;

class MyIndent extends Model
{
    protected $table = 'hrms_indent_request';

    protected $guarded = [];

    public function employee(){
    	return $this->belongsTo('App\Models\Employees\EmployeeMast', 'user_id', 'user_id');
    }
}
