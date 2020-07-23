<?php

namespace App\Http\Controllers\issue;

use Auth;
use Illuminate\Http\Request;
use App\Models\issue\MyIndent;
use App\Models\issue\IssueIndent;
use App\Http\Controllers\Controller;
use App\Models\Employees\EmployeeMast;


class MyIndentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emp = EmployeeMast::where('user_id', Auth::id())->first();

        $indent = IssueIndent::where('user_id', Auth::id())->get();

        return view('issue.employees.IndentAcceptance.index', compact('emp', 'indent'));
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
        $this->validate($request, [
            'description' => 'required'
        ]);

        $req = MyIndent::create([
                    'user_id'       => Auth::id(),
                    'description'   => $request->description
                ]);

        return redirect()->route('my-indent.index')->with('success', 'Request has been submitted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function show($user_id)
    {
        $myrequest = MyIndent::where('user_id', $user_id)->get();

        return view('issue.employees.IndentAcceptance.show', compact('myrequest'));
    }*/

    
    public function showTab(Request $request, $btnId)
    {
        
        if($btnId == 'myIndentList'){

            return view('issue.employees.IndentAcceptance.myindent');

        }else{

            $myrequest = MyIndent::where('user_id', $request->user_id)->get();

            return view('issue.employees.IndentAcceptance.show', compact('myrequest'));

        }
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

        IssueIndent::where('id', $id)
            ->update([
                'user_action'   => 1,
                'received_date' => $request->received_date
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MyIndent::where('id', $id)->delete();

    }
}
