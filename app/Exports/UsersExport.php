<?php

namespace App\Exports;


use App\Models\Birthday;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class UsersExport implements FromQuery, WithMapping, WithHeadings
{
	use Exportable;

    public function query()
    {
        $data = Birthday::query();
        return $data;
    }
    public function map($data) : array
    {
    	return [
    		$data->name,
    		$data->mobile_number,
    		date('Y-m-d',strtotime($data->date_of_birth)),
    	];
    }
    public function headings() : array
    {
    	 return ['Name','Mobile Number','Date Of Birth'];
    }
}
