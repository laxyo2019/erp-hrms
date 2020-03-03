<?php

namespace App\Exports;


use App\Models\Birthday;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
   
    public function collection()
    {
        return Birthday::all();
    }
}
