<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Models\payroll\Welfare;
use App\Models\Master\LedgerMast;
use App\Http\Controllers\Controller;


class WelfareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $welfares = Welfare::with(['ledger'])->get();
        return view('payroll.welfare.index', compact('welfares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ledgers = LedgerMast::all();
        return view('payroll.welfare.create', compact('ledgers'));
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
            'code'           => 'required',
            'description'    => 'required',
            'ledger'         => 'required',
            'cal_procedure'  => 'required',
            'print_order'    => 'required',
            'active'         => 'required',
            'prorated'       => 'required',
            'type'           => 'required',
            'employer_contri'=> 'required',
            'display_payslip'=> 'required'
        ]);

        Welfare::create([
            'code'              =>  $request->code,
            'description'       =>  $request->description,
            'ledger_id'         =>  $request->ledger,
            'print_order'       =>  $request->print_order,
            'calculat_proc'     =>  $request->cal_procedure,
            'active'            =>  $request->active,
            'type'              =>  $request->type,
            'prorated'          =>  $request->prorated,
            'emp_contribution'  =>  $request->employer_contri,
        ]);

        return redirect('hrpayroll/welfare')->with('success', 'Request has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $welfare = Welfare::where('id', $id)->first();

        return view('payroll.welfare.show', compact('welfare'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $welfare = Welfare::where('id', $id)->first();
        $ledgers = LedgerMast::all();

        return view('payroll.welfare.edit', compact('welfare', 'ledgers'));
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
            'code'           => 'required',
            'description'    => 'required',
            'ledger'         => 'required',
            'cal_procedure'  => 'required',
            'print_order'    => 'required',
            'active'         => 'required',
            'prorated'       => 'required',
            'type'           => 'required',
            'employer_contri'=> 'required',
            'display_payslip'=> 'required'
        ]);

        Welfare::where('id', $id)
            ->update([
                'code'              =>  $request->code,
                'description'       =>  $request->description,
                'ledger_id'         =>  $request->ledger,
                'print_order'       =>  $request->print_order,
                'calculat_proc'     =>  $request->cal_procedure,
                'active'            =>  $request->active,
                'type'              =>  $request->type,
                'prorated'          =>  $request->prorated,
                'emp_contribution'  =>  $request->employer_contri,
        ]);

        return redirect('hrpayroll/welfare')->with('success', 'Request has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Welfare::where('id', $id)->delete();

        return back()->with('success', 'Record has been deleted.');
    }
}
