<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveApprovalDetail extends Model
{
    use SoftDeletes;
    protected $table = 'hrms_leave_approval_detail';

    protected $fillable =	['id', 'leave_apply_id', 'user_id', 'approver_id', 'actions', 'paid_count', 'unpaid_count', 'carry', 'approver_remark'];
    
    protected $guarded = [];
    
}
