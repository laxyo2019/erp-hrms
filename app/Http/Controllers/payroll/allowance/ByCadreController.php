<?php

namespace App\Http\Controllers\payroll\allowance;

use Illuminate\Http\Request;
use App\Models\Master\Cadre;
use App\Models\payroll\Welfare;
use App\Models\Master\LedgerMast;
use App\Http\Controllers\Controller;
use App\Models\payroll\allowance\ByCadre;

class ByCadreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allowanceIndex(){

        return view('payroll.allowance.index');
    }

    public function index()
    {
        $allowances = ByCadre::with(['welfare', 'cadre'])->get();

        return view('payroll.allowance.cadre.index', compact('allowances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $welfares = Welfare::all();
        $cadres   = Cadre::all();

        return view('payroll.allowance.cadre.create', compact('welfares', 'cadres'));
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
            'cadre'     => 'required',
            'value'     => 'required',
            'active'    => 'required'
        ]);

        ByCadre::create([
            'welfare_id'=> $request->welfare,
            'cadre_id'  => $request->cadre,
            'value'     => $request->value,
            'percentage'=> $request->percentage,
            'active'    => $request->active
        ]);

        return redirect('hrpayroll/allowance/by-cadre')->with('success', 'Record has been added.');
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
        $cad      = ByCadre::where('id', $id)->first();
        $welfares = Welfare::all();
        $cadres   = Cadre::all();

        return view('payroll.allowance.cadre.edit', compact('cad', 'welfares', 'cadres'));
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
            'cadre'     => 'required',
            'value'     => 'required',
            'active'    => 'required'
        ]);

        ByCadre::where('id', $id)
            ->update([
            'welfare_id'=> $request->welfare,
            'cadre_id'  => $request->cadre,
            'value'     => $request->value,
            'percentage'=> $request->percentage,
            'active'    => $request->active
        ]);

        return redirect('hrpayroll/allowance/by-cadre')->with('success', 'Record has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ByCadre::where('id', $id)->delete();

        return back()->with('success', 'Record has been deleted.');
    }
}
