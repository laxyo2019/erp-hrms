<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class EmpLeave extends Model
{
	use SoftDeletes;
    protected $table = 'leave_mast';

    protected $fillable = ['user_id', 'reports_to', 'leave_type_id', 'day_status', 'from', 'to', 'count', 'reason', 'file_path', 'addr_during_leave', 'contact_no', 'subadmin_approval', 'admin_approval', 'applicant_remark', 'approver_remark', 'hr_remark', 'carry', 'paid_count', 'unpaid_count' , 'generates_after', 'max_apply_once', 'min_apply_once', 'max_days_month', 'max_apply_month', 'max_apply_year', 'carry_forward'];
}
