<?php

namespace App\Models\payroll;

use Illuminate\Database\Eloquent\Model;

class Welfare extends Model
{
    protected $table	= 'hrms_welfare';

    protected $guarded	= [];

    public function ledger(){
    	return $this->belongsTo('App\Models\Master\LedgerMast', 'ledger_id');
    }
}
