<?php

namespace App\Http\Controllers\loan;

use Auth;
use validator;
use Illuminate\Http\Request;
use App\Models\Master\LoanType;
use App\Models\loan\LoanRequest;
use App\Models\loan\loanHistory;
use App\Models\loan\LoanInterest;
use App\Http\Controllers\Controller;
use App\Models\Employees\EmployeeMast;

use DB;
use App\User;
use Mail;

class LoanRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*Mail::send(['text' => 'mail'], ['name', 'sam'], function($message){
                $message->to('ajaym.er.121@gmail.com')->subject('for testing');
                $message->from('ajaymagarde.r.121@gmail.com');
        });

        $employee = EmployeeMast::select('comp_email')->get();
        $email = [];

        foreach($employee as $index){

            $email[] = $index->comp_email;
        }

        return $email;*/

        //$user = User::select('id', 'email')->orderBy('id', 'DESC')->first();

        //$employees = EmployeeMast::select('user_id', 'comp_email')->get();

        //$employee['email'] = $employees->comp_email 
        /*foreach($employees as $index){

            $emp_emails[] = $index->comp_email;
        }*/

        $requests = LoanRequest::with(['loanType'])
                        ->where('user_id', Auth::id())->get();

        return view('loan.requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $emp = EmployeeMast::where('user_id', Auth::id())->first();

        $types = LoanType::all();

        $interest = LoanInterest::first();

        return view('loan.requests.create', compact('emp', 'types', 'interest'));
    }

    public function showType(Request $request){

        $type = LoanType::where('id', $request->type)->first();

        return $type;
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
            'interest_rate'     => 'required',
            //'emp_code'          => 'required',
            'loan_type'         => 'required',
            'loan_amount'       => 'required',
            'total_amount'      => 'required',
            'monthly_deduction' => 'required',
            'tenure'            => 'required',
            'total_interest'    => 'required',
            'reason'            => 'required',

        ]);

        LoanRequest::create([
            'user_id'           => Auth::id(),
            'interest_rate'     => $request->interest_rate,
            'loan_type_id'      => $request->loan_type,
            'requested_amt'     => $request->loan_amount,
            'tenure'            => $request->tenure,
            'total_amount'      => $request->total_amount,
            'monthly_deduction' => $request->monthly_deduction,
            'total_interest'    => $request->total_interest,
            'reason'            => $request->reason,
            'posted'            => date("m-j-Y")
            ]);

        return redirect('loan-request')->with('success', 'Applied for loan succesfully.');
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

        return view('loan.requests.show', compact('request'));
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

        $emp = EmployeeMast::where('user_id', Auth::id())->first();

        $types = LoanType::all();

        return view('loan.requests.edit', compact('request', 'emp', 'types'));
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
            'interest_rate'     => 'required',
            'loan_type'         => 'required',
            'loan_amount'       => 'required',
            'monthly_deduction' => 'required',
            'tenure'            => 'required',
            'total_interest'    => 'required',
            'reason'            => 'required',

        ]);

        LoanRequest::where('id', $id)
            ->update([
            'user_id'           => Auth::id(),
            'interest_rate'     => $request->interest_rate,
            'loan_type_id'      => $request->loan_type,
            'requested_amt'     => $request->loan_amount,
            'tenure'            => $request->tenure,
            'monthly_deduction' => $request->monthly_deduction,
            'total_interest'    => $request->total_interest,
            'reason'            => $request->reason,
            'posted'            => date("m-j-Y")
            ]);

        return redirect('loan-request')->with('success', 'Request has been updated.');
    }

    /**
     * Show/Add loan details of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function loanMonthlyHistory( $id)
    {
        $request = LoanRequest::where('id', $id)
                        ->with('employee')->first();

        

        return view('loan.requests.history', compact('request'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LoanRequest::where('id', $id)->delete();

        return back()->with('success', 'Request deleted successfully.');
    }
}
