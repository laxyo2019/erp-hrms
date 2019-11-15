<?php

namespace App\Imports;

use App\Holiday;
use Maatwebsite\Excel\Concerns\ToModel;

class HolidaysImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Holiday([
            //
        ]);
    }
}
