<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master\Holiday;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HolidaysExport;

class HolidayController extends Controller
{
    public function index(){

    	$holidays = Holiday::all();

    	return view('leave.holidays.index', compact('holidays'));
    }

    public function store(Request $request){

    	//dd($request->all());
    }

    public function import(){

    }

    public function export(){
    	return Excel::download(new HolidaysExport, 'holidays.xlsx');
    }
}
