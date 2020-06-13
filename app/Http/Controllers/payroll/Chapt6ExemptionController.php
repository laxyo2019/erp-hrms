<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Models\payroll\settings\Chapt6Head;
use App\Http\Controllers\Controller;
use App\Models\Master\Chapt6Section;
use App\Models\payroll\Chapt6Exemption;
use App\Models\Employees\EmployeeMast;


class Chapt6ExemptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exemptions = Chapt6Exemption::with(['section', 'head', 'employee'])
                        ->get();

        return view('payroll.exemption.index', compact('exemptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections  = Chapt6Section::orderBy('id')->get();
        $employees = EmployeeMast::all();

        return view('payroll.exemption.create', compact('sections', 'employees'));
    }

    /**
     * Show data based on Chapter 6 Sections .
     *
     */

    public function showHeads(Request $request){

        $heads = Chapt6Head::where('chapt6_section_id', $request->section_id)->pluck('id', 'head');
        return response()->json($heads);
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
            'section'      => 'required',
            'section_head' => 'required',
            'emp_name'     => 'required',
            'year_from'    => 'required',
            'year_to'      => 'required|after:year_from',
            'exempt_amt'   => 'required',
            ],[
                'year_to.after' => 'Value must be greater than previous date'
            ]);

        //$emp = EmployeeMast::where('emp_code', $request->emp_code)->select('user_id')->first();

        Chapt6Exemption::create([
            'chapt6_section_id' => $request->section,
            'chapt6_head_id'    => $request->section_head,
            'user_id'           => $request->emp_name,
            'year_from'         => $request->year_from,
            'year_to'           => $request->year_to,
            'exemption_amt'     => $request->exempt_amt,
            'incom_other_src'   => $request->incom_other_src,
            'notes'             => $request->notes
        ]);

        return redirect('hrpayroll/chapter6-exemption')->with('success', 'Exemption has been added.');
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
        $exemption = Chapt6Exemption::where('id', $id)->first();

        $sections  = Chapt6Section::all();

        $heads     = Chapt6Head::where('chapt6_section_id', $exemption->chapt6_section_id)->get();

        return view('payroll.exemption.edit', compact('exemption', 'sections', 'heads'));
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
            'section'      => 'required',
            'section_head' => 'required',
            'emp_name'     => 'required',
            'emp_code'     => 'required',
            'financial_yr' => 'required',
            'exempt_amt'   => 'required',
        ]);

        $emp = EmployeeMast::where('emp_code', $request->emp_code)->select('user_id')->first();

        Chapt6Exemption::where('id', $id)
            ->update([
                'chapt6_section_id' => $request->section,
                'chapt6_head_id'    => $request->section_head,
                'emp_name'          => $request->emp_name,
                'emp_code'          => $request->emp_code,
                'user_id'           => $emp->user_id,
                'financial_year'    => $request->financial_yr,
                'exemption_amt'     => $request->exempt_amt,
                'incom_other_src'   => $request->incom_other_src,
                'notes'             => $request->notes
            ]);
        return redirect('payroll/chapter6-exemption')->with('success', 'Record has been update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Chapt6Exemption::where('id', $id)->delete();

        return back()->with('success', 'Record has been deleted.');
    }
}
