<?php

namespace App\Models\Spatie;

use Illuminate\Database\Eloquent\Model;

class PermissionAlias extends Model
{
    protected $table	= 'permission_alias';
    protected $fillable = ['permission_id', 'alias'];
}
