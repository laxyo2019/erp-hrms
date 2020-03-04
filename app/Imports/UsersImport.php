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
        $data1 = array(); 
        foreach ($rows as $row) 
        {
            //echo ;


            if($row['mobile_number'] !='' && $row['name'] !='' && $row['date_of_birth'] !='' ){
            	$registration_date = Date::excelToDateTimeObject($row['date_of_birth']); 
                $date1 = strtotime(date('Y').'-'.$registration_date->format('m-d'));
                $date2 = strtotime(date('Y-m-d'));
                
                if ($date2 >= $date1 ){
                  $date = date('Y', strtotime('+1 year')).'-'.$registration_date->format('m-d') ;
                }   
                else{
                    $date = date('Y').'-'.$registration_date->format('m-d') ;
                }   
            	$data = ['name'=>$row['name'],'mobile_number'=>$row['mobile_number'],'date_of_birth'=>$registration_date->format('Y-m-d'),'next_date'=>$date];
                Birthday::create($data);
            }
        }
        return true;
    }
}

