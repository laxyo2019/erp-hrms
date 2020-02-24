<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Models\Master\CompMast;
use App\Models\Employees\CompBranch;
use App\Http\Controllers\Controller;

class CompBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = CompBranch::with('branch')->paginate(10);

        return view('settings.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = CompMast::orderBy('name', 'ASC')->get();

        return view('settings.branches.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CompBranch::create([
            'comp_id' => $request->comp_id,
            'city'    => $request->city,
            'address' => $request->address
        ]);

        return redirect()->route('branches.index')->with('success', 'Branch added successfully.');
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
        $companies = CompMast::orderBy('name', 'ASC')->get();
        $branch    = CompBranch::findOrFail($id);

        return view('settings.branches.edit', compact('companies', 'branch'));
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
        CompBranch::findOrFail($id)
            ->update([
                'comp_id' => $request->comp_id,
                'city'    => $request->city]);

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
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
