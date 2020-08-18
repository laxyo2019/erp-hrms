<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Models\Master\Holiday;
use App\Exports\HolidaysExport;
use App\Imports\HolidaysImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\ErrorHolidayExport;

class HolidayController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
    }

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
    					'date'	=> 'required|unique:hrms_holidays,date'
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

    public function destroy(Request $request, $id){
        
        $leave_type = Holiday::findOrFail($id);
        $leave_type->delete();

        return back()->with('success', 'Deleted successfully.');
    }

    public function import(Request $request){

    	$records = Excel::import(new HolidaysImport, $request->file('import'));
        die;
        if($records){
            return redirect()->route('holidays.index')->with('success', 'Updated Holidays');    
        }    	
    }

    public function export(){
    	return Excel::download(new HolidaysExport, 'holidaysExport.xlsx');
    }

    /*public function array_Data( $data){

    	return $data = [
    					'id'	=> $data['id'],
    					'title' => $data['title'],
    					'date'	=> $data['date'],
    					'desc'	=> $data['desc']
    					];
    }*/

    
}
