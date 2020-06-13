<?php

namespace App\Http\Controllers\payroll\allowance;

use Illuminate\Http\Request;
use App\Models\payroll\Welfare;
use App\Models\Master\Designation;
use App\Http\Controllers\Controller;
use App\Models\payroll\allowance\ByDesignation;

class ByDesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allowances = ByDesignation::with(['welfare', 'designation'])->get();

        return view('payroll.allowance.designation.index', compact('allowances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $welfare     = Welfare::all();
        $designation = Designation::all();

        return view('payroll.allowance.designation.create', compact('welfare', 'designation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'welfare'   => 'required',
            'designation'=> 'required',
            'value'     => 'required',
            'active'    => 'required'
        ]);

        ByDesignation::create([
            'welfare_id'        => $request->welfare,
            'designation_id'     => $request->designation,
            'value'             => $request->value,
            'percentage'        => $request->percentage,
            'active'            => $request->active
        ]);

        return redirect('hrpayroll/allowance/by-designation')->with('success', 'Record has been updated.');
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
        $byDesignation  = ByDesignation::where('id', $id)->first();
        $welfares       = Welfare::all();
        $designations   = Designation::all();

        return view('payroll.allowance.designation.edit', compact('byDesignation', 'welfares', 'designations'));
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
            'welfare'   => 'required',
            'designation'=> 'required',
            'value'     => 'required',
            'active'    => 'required'
        ]);

        ByDesignation::where('id', $id)
            ->update([
            'welfare_id'        => $request->welfare,
            'designation_id'    => $request->designation,
            'value'             => $request->value,
            'percentage'        => $request->percentage,
            'active'            => $request->active
        ]);

        return redirect('hrpayroll/allowance/by-designation')->with('success', 'Record has been added.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ByDesignation::where('id', $id)->delete();

        return back()->with('success', 'Record has been deleted.');
    }
}
