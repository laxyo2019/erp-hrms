<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\NoDues;
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

        $emp_hod = EmployeeMast::where('user_id', $emp->emp_hod)->first();

        $hod     = Hod::with(['employee', 'department'])->get();

        return view('nodues.request.create', compact('hod', 'emp_hod', 'emp'));
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
