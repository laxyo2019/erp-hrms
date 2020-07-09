<?php

namespace App\Http\Controllers\loan;

use Illuminate\Http\Request;
use App\Models\loan\LoanType;
use App\Http\Controllers\Controller;

class LoanTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = LoanType::all();

        return view('loan.setting.type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('loan.setting.type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'interest_rate' => 'required'

        ]);

        LoanType::create([
            'name'          =>  $request->name,
            'interest_rate' => $request->interest_rate,
            'description'   => $request->description
            ]);

        return redirect('loan-management/loan-types')->with('success', 'Request has been added.');
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
        $type = LoanType::where('id', $id)->first();

        return view('loan.setting.type.edit', compact('type'));
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
        $request->validate([
            'name'          => 'required',
            'interest_rate' => 'required'

        ]);

        LoanType::where('id', $id)
            ->update([
            'name'          =>  $request->name,
            'interest_rate' => $request->interest_rate,
            'description'   => $request->description
            ]);

        return redirect('loan-management/loan-types')->with('success', 'Request has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LoanType::where('id', $id)->delete();
        return redirect('loan-management/loan-types')->with('success', 'Request has been deleted.');
    }
}
