<?php

namespace App\Http\Controllers\payroll\allowance;

use App\Models\Master\Site;
use Illuminate\Http\Request;
use App\Models\payroll\Welfare;
use App\Http\Controllers\Controller;
use App\Models\payroll\allowance\BySite;

class BySiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allowances = BySite::with(['welfare', 'site'])->get();

        return view('payroll.allowance.site.index', compact('allowances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $welfare= Welfare::all();
        $sites  = Site::all();

        return view('payroll.allowance.site.create', compact('welfare', 'sites'));
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
            'site'      => 'required',
            'value'     => 'required',
            'active'    => 'required'
        ]);

        BySite::create([
            'welfare_id'        => $request->welfare,
            'site_id'           => $request->site,
            'value'             => $request->value,
            'percentage'        => $request->percentage,
            'active'            => $request->active
        ]);

        return redirect('hrpayroll/allowance/by-site')->with('success', 'Record has been added.');
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
        $bySite         = BySite::where('id', $id)->first();
        $welfares       = Welfare::all();
        $sites          = Site::all();

        return view('payroll.allowance.site.edit', compact('bySite', 'welfares', 'sites'));
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
            'site'      => 'required',
            'value'     => 'required',
            'active'    => 'required'
        ]);

        BySite::where('id', $id)
            ->update([
            'welfare_id'        => $request->welfare,
            'site_id'           => $request->site,
            'value'             => $request->value,
            'percentage'        => $request->percentage,
            'active'            => $request->active
        ]);

        return redirect('hrpayroll/allowance/by-site')->with('success', 'Record has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BySite::where('id', $id)->delete();

        return back()->with('success', 'Record has been deleted.');
    }
}
