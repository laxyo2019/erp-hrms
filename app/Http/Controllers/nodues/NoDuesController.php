<?php

namespace App\Http\Controllers\nodues;

use Auth;
use App\Models\NoDues;
use Illuminate\Http\Request;
use App\Models\Employees\Hod;
use App\Models\nodues\NoDuesApproval;
use App\Http\Controllers\Controller;
use App\Models\Employees\EmployeeMast;

class NoDuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emp     = EmployeeMast::where('user_id', Auth::id())->first();

        $request = NoDues::where('user_id', Auth::id())->first();

        $hod_approval = NoDuesApproval::with(['employee', 'department'])
                        ->get();

        return view('nodues.request.create', compact('hod_approval', 'emp', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $emp     = EmployeeMast::where('user_id', Auth::id())->first();

        $request = NoDues::where('user_id', Auth::id())->first();

        $hod_approval = NoDuesApproval::with(['employee', 'department'])
                        ->get();

        return view('nodues.request.create', compact('hod_approval', 'emp', 'request'));
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
            'date_join' => 'required',
            'date_leave'=> 'required'
        ]);

        $emp = EmployeeMast::with(['department'])
                ->where('user_id', Auth::id())->first();

        $nodues_request = NoDues::create([
                        'user_id'       => Auth::id(),
                        'department_id' => $emp->dept_id,
                        'emp_hod'       => $emp->emp_hod,
                        'date_join'     => $request->date_join,
                        'date_leave'    => $request->date_leave,
                        'assets_description' => $request->assets_description,
                        'posted'        => date("m-j-Y")
                    ]);

        #Create Nodues Approval Records

        $emphod = EmployeeMast::where('user_id', $emp->emp_hod)->first();

        $hod = Hod::select('user_id', 'depart_id')->get();

        $hod_ids = [];

        $i = 0;
        foreach($hod as $index){

            $hod_ids[$i]['user'] = $index->user_id;
            $hod_ids[$i]['depart'] = $index->depart_id;

            $i+=1;
        }

        //Preppend Employee's Hod info to global hod's array

        $emp_hod['user'] = $emphod->user_id;
        $emp_hod['depart'] = $emphod->dept_id;

        array_unshift($hod_ids, $emp_hod);

        foreach($hod_ids as $index){
            NoDuesApproval::create([
                'nodues_request_id' =>  $nodues_request->id,
                'hod_user_id'       =>  $index['user'],
                'hod_depart_id'     =>  $index['depart']
            ]);
        }

        return back()->with('success', 'Request has been added.');

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
        //
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
