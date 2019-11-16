<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
	use SoftDeletes;

	protected $fillable = ['id', 'title', 'date', 'desc'];
    
}
