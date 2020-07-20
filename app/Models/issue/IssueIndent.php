<?php

namespace App\Models\issue;

use Illuminate\Database\Eloquent\Model;

class IssueIndent extends Model
{
    protected $table = 'hrms_issue_indent';
    
    protected $guarded = [];

    public function department(){
    	return $this->belongsTo('App\Models\Master\DeptMast', 'dept_id');
    }
}
