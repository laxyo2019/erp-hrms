<?php

namespace App\Http\Controllers\payroll\settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master\Chapt6Section;
use App\Models\payroll\settings\Chapt6Head;

class Chapter6HeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Responsegve
     */
    public function index()
    {
        $data = Chapt6Head::with('section')
                    ->get();

        return view('settings.payroll.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $chapt6 = Chapt6Section::all();
        return view('settings.payroll.create', compact('chapt6'));
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
            'chapt6' => 'required',
            'heads'  => 'required'
        ]);

        Chapt6Head::create([
            'chapt6_section_id' => $request->chapt6,
            'head'              => $request->heads,
            'description'       => $request->description
        ]);

        return redirect('payroll/chapter6-head')->with('success', 'record has been added.');
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
        $head     = Chapt6Head::where('id', $id)->first();
        $sections = Chapt6Section::all();

        return view('settings.payroll.edit', compact('head', 'sections'));
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
            'chapt6' => 'required',
            'heads'  => 'required'
        ]);

        Chapt6Head::where('id', $id)
            ->update([
                'chapt6_section_id' => $request->chapt6,
                'head'              => $request->heads,
            ]);

        return redirect('payroll/chapter6-head')->with('success', 'Record has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Chapt6Head::where('id', $id)->delete();

        return back()->with('success', 'Record has been deleted.');
    }
}
