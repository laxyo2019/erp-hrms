<?php

namespace App\Http\Controllers\payroll\allowance;

use Illuminate\Http\Request;
use App\Models\payroll\Welfare;
use App\Http\Controllers\Controller;
use App\Models\Employees\EmployeeMast;
use App\Models\payroll\allowance\ByEmployee;

class ByEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allowances = ByEmployee::with(['welfare', 'employee'])->get();

        return view('payroll.allowance.employee.index', compact('allowances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $welfare     = Welfare::all();
        $employees   = EmployeeMast::all();

        return view('payroll.allowance.employee.create', compact('welfare', 'employees'));
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
            'employee'  => 'required',
            'value'     => 'required',
            'active'    => 'required'
        ]);

        ByEmployee::create([
            'welfare_id'        => $request->welfare,
            'employee_id'       => $request->employee,
            'value'             => $request->value,
            'percentage'        => $request->percentage,
            'active'            => $request->active
        ]);

        return redirect('hrpayroll/allowance/by-employee')->with('success', 'Record has been added.');
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
        $byEmployee  = ByEmployee::where('id', $id)->first();
        $welfares    = Welfare::all();
        $employees   = EmployeeMast::all();

        return view('payroll.allowance.employee.edit', compact('byEmployee', 'welfares', 'employees'));
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
            'employee'  => 'required',
            'value'     => 'required',
            'active'    => 'required'
        ]);

        ByEmployee::where('id', $id)
            ->update([
            'welfare_id'        => $request->welfare,
            'employee_id'       => $request->employee,
            'value'             => $request->value,
            'percentage'        => $request->percentage,
            'active'            => $request->active
        ]);

        return redirect('hrpayroll/allowance/by-employee')->with('success', 'Record has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ByEmployee::where('id', $id)->delete();

        return back()->with('success', 'Record has been deleted.');
    }
}
