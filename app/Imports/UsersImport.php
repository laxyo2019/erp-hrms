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

            if($row['mobile_number'] !='' && $row['name'] !='' && $row['date_of_birth'] !='' ){

            	$registration_date = date('Y-m-d',strtotime($row['date_of_birth'])); 
                $date1 = date('Y').'-'.date('m-d',strtotime($row['date_of_birth']));
                $date2 = strtotime(date('Y-m-d')); 
                
                if ($date2 >= $date1 ){
                  $date = date('Y', strtotime('+1 year')).'-'.date('m-d',strtotime($row['date_of_birth'])) ;
                }   
                else{
                    $date = date('Y').'-'.date('m-d',strtotime($row['date_of_birth'])) ;
                }   
            	$data = ['name'=>$row['name'],'mobile_number'=>$row['mobile_number'],'date_of_birth'=>$registration_date,'next_date'=>$date];
                $exits = Birthday::where('mobile_number',$data['mobile_number'])->first();
                dd($exits);
                if(empty($exits)){
                    Birthday::create($data);
                }
            }
        }
        return true;
    }
}

