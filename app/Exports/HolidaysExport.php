<?php

namespace App\Exports;

use App\Models\Master\Holiday;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class HolidaysExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;


    public function query(){

    	$holidays = Holiday::where('deleted_at', null);

    	return $holidays;
    }

	public function map($holidays): array {

		return [

			$holidays->id,
			$holidays->title,
			$holidays->date,
			$holidays->desc
		];
		
	}

	public function headings(): array {

		return [
			'id',
			'title',
			'date',
			'desc'

		];
	}
}
