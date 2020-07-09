<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Employees\EmployeeMast;
class EmployeessExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        Eployees
    }
    public function map($employees):array(){

    }
}
