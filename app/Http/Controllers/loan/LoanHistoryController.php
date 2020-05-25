<?php

namespace App\Http\Controllers\loan;

use Illuminate\Http\Request;
use App\Models\loan\LoanHistory;
use App\Models\loan\LoanRequest;
use App\Http\Controllers\Controller;


class LoanHistoryController extends Controller
{
    /**
     * Add Monthly deduction to specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        LoanHistory::create([
                'loan_request_id'=>  $id,   
                'user_id'        =>  $request->user_id,
                'balance'        =>  $request->balance,
                'deduction'      =>  $request->deduction]);

        return back()->with('success', 'Transaction has been updated.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function update(Request $request, $id)
    {
        
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LoanHistory::where('id', $id)->delete();

        return back()->with('success', 'Transaction record has been deleted');
    }
}
