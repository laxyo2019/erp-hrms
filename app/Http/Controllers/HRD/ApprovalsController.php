<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\EmployeeMast;
use App\Models\Master\ApprovalAction;
use Illuminate\Http\Request;
use App\Models\Master\ActivityMast;
use App\Models\Master\DeptMast;

class ApprovalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actions = ApprovalAction::orderBy('id', 'asc')->get();
        return view('HRD.approvals.index', compact('actions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('HRD.approvals.create');
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
            'name' => 'required'
        ]);
        
       $action = new ApprovalAction;
       $action->name       = $request->name;
       $action->description= $request->desc;  
       $action->reverse    = $request->reverse;
       $action->reason     = $request->reason;
       $action->save();

       return redirect('approval-action')->with('success', 'Action created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $actions = ApprovalAction::findOrFail($id);
        return view('HRD.approvals.edit', compact('actions'));
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
            'name' => 'required'
        ]);

        $actions = ApprovalAction::findOrFail( $id);
        $actions->name        = $request->name;
        $actions->description = $request->desc;
        $actions->reverse     = $request->reverse;
        $actions->reason      = $request->reason;
        $actions->save();

        return redirect('approval-action')->with('success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        ApprovalAction::findOrFail( $id)->delete();

        return back()->with('success', 'Record deleted successfully');
    }
}
