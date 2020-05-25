<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class LoanType extends Model
{
	use SoftDeletes;
    protected $table = 'hrms_loan_types';

    protected $guarded = [];
}
