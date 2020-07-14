<?php

namespace App\Http\Controllers;

use Auth;
//use App\Models\NoDues;
use App\Models\nodues\NoDues;
use Illuminate\Http\Request;
use App\Models\Employees\Hod;
use App\Models\Employees\EmployeeMast;

class NoDuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodues = NoDues::all();

        return view('nodues.request.index', compact('nodues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $emp     = EmployeeMast::where('user_id', Auth::id())->first();

        $emp_hod = EmployeeMast::with(['department'])
                        ->where('user_id', $emp->emp_hod)
                        ->first();

        $hod     = Hod::with(['employee', 'department'])->get();

        $request = NoDues::where('user_id', Auth::id())->first();

        return view('nodues.request.create', compact('hod', 'emp_hod', 'emp', 'request'));
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
            'date_join' => 'required',
            'date_leave'=> 'required'
        ]);

        $emp = EmployeeMast::with(['department'])
                ->where('user_id', Auth::id())->first();

        NoDues::create([
            'user_id'       => Auth::id(),
            'department_id' => $emp->dept_id,
            'emp_hod'       => $emp->emp_hod,
            'date_join'     => $request->date_join,
            'date_leave'    => $request->date_leave,
            'assets_description' => $request->assets_description,
            'posted'        => date("m-d-Y")
        ]);

        return redirect()->route('no-dues-request.index')->with('success', 'Request has been added.');

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
        //
    }
}
