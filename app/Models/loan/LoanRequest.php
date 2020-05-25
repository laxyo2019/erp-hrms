<?php

namespace App\Models\loan;

use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    protected $table   = 'hrms_loan_request';

    protected $guarded = [] ;

    public function loanType(){
    	return $this->belongsTo('App\Models\loan\LoanType');
    }

    public function employee(){
    	return $this->belongsTo('App\Models\Employees\EmployeeMast', 'user_id', 'user_id');
    }
}
