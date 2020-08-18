<?php

namespace App\Http\Controllers\loan;

use Auth;
use Illuminate\Http\Request;
use App\Models\Master\LoanType;
use App\Models\loan\LoanRequest;
use App\Models\loan\LoanHistory;
use App\Http\Controllers\Controller;
use App\Models\Employees\EmployeeMast;

class LoanListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexHr()
    {
        $requests = LoanRequest::with(['employee', 'loanType'])
                        ->get();

        return view('loan.listing.index-hr', compact('requests'));
    }

    public function indexSubAdmin()
    {
        $requests = LoanRequest::with(['employee', 'loanType'])
                        ->where('hr_approval', 1)
                        ->get();
                        
        return view('loan.listing.index-subadmin', compact('requests'));
    }

    public function indexAdmin()
    {
        $requests = LoanRequest::with(['employee', 'loanType'])
                        ->where('subadmin_approval', 1)
                        ->where('hr_approval', 1)
                        ->get();

        return view('loan.listing.index-admin', compact('requests'));
    }

    public function indexAccountant()
    {
        $requests = LoanRequest::with(['employee', 'loanType'])
                        ->where('admin_approval', 1)
                        ->where('subadmin_approval', 1)
                        ->where('hr_approval', 1)
                        ->get();
                        
        return view('loan.listing.index-accountant', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request = LoanRequest::with(['loanType'])
                        ->where('id', $id)->first();

        return view('loan.listing.show', compact('request'));
    }

    public function HrApproval(Request $request){

        $status = $request->action == 1 ? 1 : 2;

        LoanRequest::where('id', $request->request_id)
            ->update(['hr_approval' => $status]);

        if($status == 1){
            $flag = 1;
        }else{
            $flag = 2;
        }

        return $flag;
    }

    public function SubAdminApproval(Request $request, $request_id){

        $status = $request->action == 1 ? 1 : 2;

        LoanRequest::where('id', $request_id)
            ->update(['subadmin_approval' => $status]);

        if($status == 1){
            $flag = 1;
        }else{
            $flag = 2;
        }

        return $flag;
    }

    public function AdminApproval(Request $request, $request_id){

        $status = $request->action == 1 ? 1 : 2;

        LoanRequest::where('id', $request_id)
            ->update([
                'admin_approval' => $status,
                'sanctioned_date'=> date("m-d-Y")]);

        if($status == 1){
            $flag = 1;
        }else{
            $flag = 2;
        }

        return $flag;
    }

    public function loanDisburse(Request $request, $request_id){

        LoanRequest::where('id', $request_id)
            ->update(['accountant_approval' => 1]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $request = LoanRequest::where('id', $id)->first();

        $emp     = EmployeeMast::where('user_id', $request->user_id)->first();

        $types   = LoanType::all();

        return view('loan.listing.edit', compact('request', 'emp', 'types'));
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
            'disburse_date' =>  'required',
            'account'       =>  'required',
            'disburse_amt'  =>  'required',
        ]);
        
        LoanRequest::where('id', $id)
            ->update([
                'disburse_date' =>  $request->disburse_date,
                'account_no'    =>  $request->account,
                'disburse_amt'  =>  $request->disburse_amt,
            ]);

        return back()->with('success', 'Form has been submitted.');
    }

    /**
     * Show the details of loan request of specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function loanMonthlyHistory( $id)
    {
        $request = LoanRequest::where('id', $id)
                        ->with('employee')->first();

        $history = LoanHistory::where('loan_request_id', $id)->get();

        return view('loan.listing.history', compact('request', 'history'));
    }
}
