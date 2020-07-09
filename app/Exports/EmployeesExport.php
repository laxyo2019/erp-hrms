<?php

namespace App\Exports;
use App\Models\Employees\EmployeeMast;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class EmployeesExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

	public function query(){
		
		$array = session('user_ids');
		if (!empty($array)) {
			$employees = EmployeeMast::query()->whereIn('user_id', $array);	
			// return $employees;
		}else{
		
		$employees = EmployeeMast::query();
		}
		return $employees;
	}

	public function map($employees): array {
		return [
			$employees->id,
			$employees->emp_code,
			$employees->emp_name,
			$employees->emp_dob,
			$employees->curr_addr,
			$employees->perm_addr,
			$employees->contact,
			$employees->alt_contact,
			$employees->alt_email,
			$employees->driv_lic,
			$employees->aadhar_no,
			$employees->voter_id,
			$employees->pan_no,
			$employees->old_uan,
			$employees->curr_uan,
			$employees->old_pf,
			$employees->curr_pf,
			$employees->old_esi,
			$employees->curr_esi,
			$employees->join_dt,
			$employees->leave_dt,
			];
	}
    
    public function headings(): array {
        
        return [
			'id',
			'emp_code',
			'emp_name',
			'emp_dob',
			'curr_addr',
			'perm_addr',
			'contact',
			'alt_contact',
			'alt_email',
			'driv_lic',
			'aadhar_no',
			'voter_id',
			'pan_no',
			'old_uan',
			'curr_uan',
			'old_pf',
			'curr_pf',
			'old_esi',
			'curr_esi',
			'join_dt',
			'leave_dt',
		];
	}

}
