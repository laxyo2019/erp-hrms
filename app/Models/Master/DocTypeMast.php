<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocTypeMast extends Model
{
    use SoftDeletes;
    protected $table = 'hrms_doc_type_mast';

}
