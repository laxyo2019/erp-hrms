<?php

namespace App\Models\Spatie;

use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\LaratrustPermission;
use Laratrust\LaratrustPermission;

class Permission extends LaratrustPermission
{
	// use HasRoles;

	//protected $table = 'permissions';
 	protected $guarded = [];
    
}
