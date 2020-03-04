<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Birthday;
use Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UsersImport implements ToCollection,WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
        	if($row['name'] !='' && $row['mobile_number'] !='' && $row['date_of_birth'] !=''){
	        	$registration_date = Date::excelToDateTimeObject($row['date_of_birth']);
	        	$data = ['name'=>$row['name'],'mobile_number'=>$row['mobile_number'],'date_of_birth'=>$registration_date->format('Y-m-d')];
	            Birthday::create($data);
        	}
        }
        return true;
    }
}

