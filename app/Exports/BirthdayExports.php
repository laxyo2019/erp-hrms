<?php

namespace App\Exports;


use App\Models\Birthday;
use App\User;

use Maatwebsite\Excel\Concerns\FromCollection;

class BirthdayExports implements FromCollection

{

    

    public function collection()

    {

        return User::all();

    }

}
