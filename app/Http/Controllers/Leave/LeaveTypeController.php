<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master\LeaveMast;

class LeaveTypeController extends Controller
{

    public function __construct(){

        $this->middleware('auth');

    }

    public function index(){

    	$leaves = LeaveMast::all();

    	return view('leave.type.index', compact('leaves'));

    }

    public function create(){

    	return view('leave.type.create');
    }

    public function store(Request $request){


        $this->validate($request, 
        [
            'leave_name'        => 'required',
            'total_leaves'      => 'nullable|numeric|between:0,99.99',
            'min_apply_once'    => 'nullable|numeric|between:0,99.99',
            'max_apply_once'    => 'nullable|numeric|between:0,99.99',
            'max_days_inmonth'  => 'nullable|numeric|between:0,99.99',
            'max_apply_month'   => 'nullable|numeric',
            'max_apply_year'    => 'nullable|numeric|between:0,99.99',
        ]);

    	$leaves = new LeaveMast;
    	$leaves->name 				= 	strtolower($request->leave_name);
    	$leaves->total 				=	$request->total_leaves;
        $leaves->generate_days      =   $request->generate_days == null ? 0.0 : $request->generate_days;
    	$leaves->max_apply_once		=	$request->max_apply_once;
    	$leaves->min_apply_once		=	$request->min_apply_once;
    	$leaves->max_days_month		=	$request->max_days_inmonth;
    	$leaves->max_apply_month	=	$request->max_apply_month;
    	$leaves->max_apply_year		=	$request->max_apply_year;
    	$leaves->carry_forward      =   $request->carry;
        $leaves->docs_required      =   $request->docs_required;
        $leaves->without_pay        =   $request->without_pay;
        $leaves->dont_show          =   $request->dont_show;
    	$leaves->save();

    	return redirect()->route('types.index')->with('success', 'Updated record successfully.');
    }

    public function show( $id){
    	
    	$leave_type = LeaveMast::find($id);
    	return view('leave.type.show', compact('leave_type'));
    }

    public function edit( $id){

    	$leave_type = LeaveMast::findOrFail($id);

    	return view('leave.type.edit', compact('leave_type'));

    }

    public function update(Request $request, $id){

        //return $request->all();
        $this->validate($request, 
        [
            'leave_name'        => 'required',
            'total_leaves'      => 'nullable|numeric|between:0,99.99',
            'min_apply_once'    => 'nullable|numeric|between:0,99.99',
            'max_apply_once'    => 'nullable|numeric|between:0,99.99|gte:min_apply_once',
            'max_days_inmonth'  => 'nullable|numeric|between:0,99.99',
            'max_apply_month'   => 'nullable|numeric|between:0,99.99',
            'max_apply_year'    => 'nullable|numeric|between:0,99.99',
            'carry'             => 'nullable'
        ]);

        $leave = LeaveMast::findOrFail($id);
        $leave->name            =  $request->leave_name;
        $leave->total           =  $request->total_leaves;
        $leave->generate_days   =  $request->generate_days == null ? 0.0 : $request->generate_days;
        $leave->max_apply_once  =  $request->max_apply_once;
        $leave->min_apply_once  =  $request->min_apply_once;
        $leave->max_days_month  =  $request->max_days_inmonth;
        $leave->max_apply_month =  $request->max_apply_month;
        $leave->max_apply_year  =  $request->max_apply_year;
        $leave->carry_forward   =  $request->carry;
        $leave->docs_required   =  $request->docs_required;
        $leave->without_pay     =  $request->without_pay;
        $leave->dont_show       =  $request->dont_show;
        $leave->save();

    	return back()->with('success', 'Updated successfully.');
    }

    public function destroy($id){

    	$leave_type = LeaveMast::findOrFail($id);
    	$leave_type->delete();

    	return back()->with('success', 'Deleted successfully.');
    }


    public function leaveGenerate(){

        
    }

}
