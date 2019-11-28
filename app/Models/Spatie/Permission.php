<?php

namespace App\Models\Spatie;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Permission extends Model
{
	use HasRoles;

	protected $table = 'model_has_permissions';
    protected $guarded = [];
    
}
