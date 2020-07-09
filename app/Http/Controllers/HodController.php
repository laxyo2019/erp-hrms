<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employees\Hod;
use App\Models\Master\DeptMast;
use App\Models\Employees\EmployeeMast;

class HodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hod        = Hod::with(['employee', 'department'])->get();
        $depart     = DeptMast::all();
        $employees  = EmployeeMast::all();

        return view('hod.index', compact('hod','depart', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $depart     = DeptMast::all();
        // $employees  = EmployeeMast::all();
        // return view('hod.create', compact('depart', 'employees'));
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
            'department'=> 'required|not_in:""',
        ]);

        foreach($request->emp as $emp){
            Hod::create([
                'depart_id' => $request->department,
                'user_id'   => $emp]);
        }

        return redirect()->route('hod.index')->with('success', 'Request has been submitted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Hod::where('id', $id)->delete();

        return back()->with('success', 'Record has been deleted.');
    }
}
