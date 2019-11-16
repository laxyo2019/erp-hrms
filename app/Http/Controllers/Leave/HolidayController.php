<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master\Holiday;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HolidaysExport;
use App\Imports\HolidaysImport;

class HolidayController extends Controller
{
    public function index(){

    	$holidays = Holiday::all();

    	return view('leave.holidays.index', compact('holidays'));
    }

    public function create(Request $request){

    	

    	return view('leave.holidays.create');
    }

    public function edit( $id){

    	$holiday = Holiday::findOrFail( $id);

    	return view('leave.holidays.edit', compact('holiday'));
    }

    public function store(Request $request){

    	$this->validate($request, [
    					'title'	=> 'required',
    					'date'	=> 'required|unique:holidays,date'
    					]);

    	$holiday 		= new Holiday;
    	$holiday->title = $request->title;
    	$holiday->date 	= $request->date;
    	$holiday->desc 	= $request->desc;
    	$holiday->save();

    	return redirect()->route('holidays.index')->with('success', 'Holiday Created.');
    }

    public function update(Request $request, $id){

    	$this->validate($request, [
    					'title'			=> 'required',
    					'holiday_date'	=> 'required'
    					]);

    	
    	Holiday::where('id', $id)
    				->update([
    					'title'	=> $request->title,
    					'date'	=> $request->holiday_date,
    					'desc'	=> $request->description
    				]);

    	return redirect()->route('holidays.index')->with('success', 'Holiday updated successfully');

    }

    public function import(Request $request){

    	$records = Excel::toCollection(new HolidaysImport, $request->file('import'));

    	$status = TRUE;
    	$error  = [];

    	foreach($records as $record){

    		foreach($record as $data){

    			if($status == true ){

    				if($data['id'] == ''){
    					$status = false;
    				}else{

    					/*if($data['id'] == Holiday::find($data['id'])->id){
    						$status = false;
    					}else{
    						$status = true;
    					}*/

    					$status = true;
    				}
    			}

    			if($status == true){

    				if($data['title'] == ''){
    					$status = false;
    				}else{
    					$status = true;
    				}
    			}

    			if($status == true){

    				if($data['date'] == ''){
    					$status = false;
    				}else{
    					$status = true;
    				}
    			}

    			if($status == true){

    				if($data['desc'] == ''){
    					$status = false;
    				}else{
    					$status = true;
    				}
    			}

    			if($status == true){

    				$data = $this->array_data($data);

    				Holiday::create($data);
    			}else if($status == false){

    				$error[] = $this->array_data($data);

    			}
    			$status = true;
    		}
    	}

    	if(count($error) != 0) {

    		return Excel::download(new ErrorHolidayExport($error), 'errorholidayexport.xlsx');
    	}

    	return redirect()->route('holidays.index')->with('success', 'Updated Holidays');
    }

    public function export(){
    	return Excel::download(new HolidaysExport, 'holidays.xlsx');
    }

    public function array_Data( $data){

    	return $data = [
    					'id'	=> $data['id'],
    					'title' => $data['title'],
    					'date'	=> $data['date'],
    					'desc'	=> $data['desc']
    					];
    }

    
}
