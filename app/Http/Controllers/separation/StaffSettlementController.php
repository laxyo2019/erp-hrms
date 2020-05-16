<?php

namespace App\Http\Controllers\separation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employees\EmployeeMast;
use App\Models\separation\StaffSeparation;
use App\Models\separation\StaffSettlement;

class StaffSettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $separation = StaffSeparation::findOrFail($id);
        $emp = EmployeeMast::where('emp_code', $separation->emp_code)->first();
        $settlement = StaffSettlement::where('separation_request_id', $id)->first();

        return view('separation.show', compact('separation', 'emp', 'settlement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'gratuity'              => 'required',
            'pending_salary'        => 'required',
            'loan_advance_recovery' => 'required',
            'other_recovery'        => 'required',
            'pay_from'              => 'required',
            'settlement_amt'        => 'required',
            'laptop'                => 'required',
            'sim'                   => 'required',
            'mediclaim'             => 'required',
            'laxyo_email'           => 'required',
            'laxyo_connect'         => 'required',
            'erp_id'                => 'required',
        ]);
        $separation_req = StaffSeparation::where('id', $id)->first();

        $emp = EmployeeMast::where('emp_code', $separation_req->emp_code)->first();

        #Check separation request is not closed. 
        #Status = 0 - OPEN
        #Status = 1 - CLOSED
        if($separation_req->status == 0){

            StaffSettlement::where('separation_request_id', $id)
                ->update([
                    'gratuity'              => $request->gratuity,
                    'pending_salary'        => $request->pending_salary,
                    'loan_advance_recovery' => $request->loan_advance_recovery,
                    'other_recovery'        => $request->other_recovery,
                    'pay_from'              => $request->pay_from,
                    'settlement_amt'        => $request->settlement_amt,
                    'laptop'                => $request->laptop,
                    'sim'                   => $request->sim,
                    'mediclaim'             => $request->mediclaim,
                    'others'                => $request->others,
                    'laxyo_email'           => $request->laxyo_email,
                    'laxyo_connect'         => $request->laxyo_connect,
                    'laxyo_erp_id'          => $request->erp_id ]);
        }
        
        return back()->with('success', 'Successfully updated.');
    }

    public function closeAccount( $id){

        StaffSeparation::where('id', $id)
            ->update([
                'status'        => 1,
                'hr_approval'   => 1]);

        StaffSettlement::where('separation_request_id', $id)
            ->update([
                'status'        => 1,
                'hr_approval'   => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
