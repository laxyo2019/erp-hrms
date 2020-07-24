<?php

namespace App\Http\Controllers\issue;

use Illuminate\Http\Request;
use App\Models\issue\IssueIndent;
use App\Models\issue\IndentRecord;
use App\Http\Controllers\Controller;
use App\Models\Employees\EmployeeMast;

class IssueIndentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indent = IndentRecord::with(['employee'])->get();

        return view('issue.hr.IssueIndent.index', compact('indent'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = EmployeeMast::with(['department'=> function($query){
                $query->select('name','id');
        }])->select('user_id', 'emp_code', 'dept_id', 'emp_name')
                        ->get();

        return view('issue.hr.IssueIndent.create', compact('employees'));
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
            'employees' => 'required',
            'emp_code'  => 'required'
        ]);

        IndentRecord::create([
            'user_id' => $request->employees
        ]);

        $i = 0;

        for($i=0; $i < count(($request->name)); $i++){

            IssueIndent::create([
                'user_id'    => $request->employees,
                'emp_code'   => $request->emp_code,
                'serial'     => $request->serial[$i],
                'name'       => $request->name[$i],
                'model'      => $request->model[$i],
                'quantity'   => $request->quantity[$i],
                'color'      => $request->color[$i],
                'issue_date' => $request->given_date[$i]
            ]);
        }

        return redirect()->route('issue-indent.index')->with('success', 'Request has been added.');
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
        $employee = EmployeeMast::where('user_id', $id)
                        ->select('id', 'user_id', 'emp_name', 'emp_code')
                        ->first();
        $employees = EmployeeMast::all();

        $issued = IssueIndent::where('user_id', $id)->get();

        return view('issue.hr.IssueIndent.edit', compact('employee', 'employees', 'issued'));
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

        //return $request->all();
        IssueIndent::where('user_id', $id)->delete();

        $i = 0;

        for($i=0; $i < count(($request->name)); $i++){

            IssueIndent::create([
                'user_id'    => $request->employees,
                'emp_code'   => $request->emp_code,
                'serial'     => $request->serial[$i],
                'name'       => $request->name[$i],
                'model'      => $request->model[$i],
                'quantity'   => $request->quantity[$i],
                'color'      => $request->color[$i],
                'issue_date' => $request->given_date[$i],
                'user_action'=> $request->user_action[$i]
            ]);
        }

        return back()->with('success', 'Request has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $reqID = explode('_', $id);

        //Delete indent record table entry
        IndentRecord::where('id', $request->arr[2])->delete();

        //Delete issue indent record table entry with same user_id
        IssueIndent::where('user_id', $request->arr[1])->delete();
    }
}
