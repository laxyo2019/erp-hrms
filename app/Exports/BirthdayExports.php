<?php

namespace App\Exports;


use App\Models\Birthday;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class BirthdayExports implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
	use Exportable;
   
    public function query()
    {
        $data = Birthday::orderBy('name','ASC');
        return $data;
    }
    public function map($data) : array
    {
    	return [
    		$data->id,
    		$data->name,
    		$data->mobile_number,
    		date('Y-m-d',strtotime($data->date_of_birth)),

    	];
    }
    public function headings() : array
    {
    	 return [
            'S. No.',
			'Name',
			'Mobile Number',
			'Date Of Birth'
        ];
    }
}
