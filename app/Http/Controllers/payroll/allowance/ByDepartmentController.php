<?php

namespace App\Http\Controllers\payroll\allowance;

use Illuminate\Http\Request;
use App\Models\Master\DeptMast;
use App\Models\payroll\Welfare;
use App\Http\Controllers\Controller;
use App\Models\payroll\allowance\ByDepartment;

class ByDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allowances = ByDepartment::with(['welfare', 'department'])->get();

        return view('payroll.allowance.department.index', compact('allowances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $welfare    = Welfare::all();
        $department = DeptMast::all();

        return view('payroll.allowance.department.create', compact('welfare', 'department'));
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
            'department'=> 'required',
            'value'     => 'required',
            'active'    => 'required'
        ]);

        ByDepartment::create([
            'welfare_id'        => $request->welfare,
            'department_id'     => $request->department,
            'value'             => $request->value,
            'percentage'        => $request->percentage,
            'active'            => $request->active
        ]);

        return redirect('hrpayroll/allowance/by-department')->with('success', 'Record has been added.');
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
        $byDepts    = ByDepartment::where('id', $id)->first();
        $welfares   = Welfare::all();
        $depts      = DeptMast::all();

        return view('payroll.allowance.department.edit', compact('byDepts', 'welfares', 'depts'));
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
            'department'=> 'required',
            'value'     => 'required',
            'active'    => 'required'
        ]);

        ByDepartment::create([
            'welfare_id'        => $request->welfare,
            'department_id'     => $request->department,
            'value'             => $request->value,
            'percentage'        => $request->percentage,
            'active'            => $request->active
        ]);

        return redirect('hrpayroll/allowance/by-department')->with('success', 'Record has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ByDepartment::where('id', $id)->delete();

        return back()->with('success', 'Record has been deleted.');
    }
}
