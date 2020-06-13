<?php

namespace App\Http\Controllers\separation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employees\EmployeeMast;
use App\Models\separation\StaffSeparation;
use App\Models\separation\StaffSettlement;

class SeparationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexHR()
    {
        $separations = StaffSeparation::all();
        return view('separation.index', compact('separations'));
    }

    public function indexSubAdmin()
    {
        $separations = StaffSeparation::where('hr_approval', 1)->get();
        return view('separation.index-subadmin', compact('separations'));
    }

    public function indexAdmin()
    {
        $separations = StaffSeparation::where('subadmin_approval', 1)->get();
        return view('separation.index-admin', compact('separations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = EmployeeMast::orderBy('user_id')->get();

        return view('separation.create', compact('employees'));
    }

    public function findEmpCode(Request $request){

        $emp_code = EmployeeMast::where('user_id', $request->user_id)->first()->emp_code;

        return $emp_code;
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
            'emp_name'         => 'required',
            'emp_code'         => 'required',
            'requested_on'     => 'required',
            'reason'           => 'required'
        ]);

        $request = StaffSeparation::create([
            'emp_name'          => $request->emp_name,
            'emp_code'          => $request->emp_code,
            'requested_on'      => $request->requested_on,
            'separation_date'   => $request->separation_date,
            'reason'            => $request->reason,
            'short_description' => $request->short_description
        ]);

        $emp = EmployeeMast::where('emp_code', $request->emp_code)->first();
        StaffSettlement::create([
            'separation_request_id' => $request->id,
            'user_id'               => $emp->user_id]);


        return redirect('separation/hr')->with('success', 'Sepration Request is added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $separation = StaffSeparation::findOrFail($id);

        // $emp = EmployeeMast::where('emp_code', $separation->emp_code)->first();

        // return view('separation.show', compact('separation', 'emp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $separation = StaffSeparation::findOrFail($id);

        return view('separation.edit', compact('separation'));
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
        StaffSeparation::where('id', $id)
            ->update([
                'emp_name'          => $request->emp_name,
                'emp_code'          => $request->emp_code,
                'requested_on'      => $request->requested_on,
                'separation_date'   => $request->separation_date,
                'reason'            => $request->reason,
                'short_description' => $request->short_description]);

        return redirect('separation/hr')->with('success', 'Request successfully updated.');
    }

    public function SubAdminApproval(Request $request, $request_id){

        $status = $request->action == 1 ? 1 : 2;

        StaffSeparation::where('id', $request_id)
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

        StaffSeparation::where('id', $request_id)
            ->update(['admin_approval' => $status]);

        if($status == 1){
            $flag = 1;
        }else{
            $flag = 2;
        }

        return $flag;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StaffSeparation::where('id', $id)->delete();
        StaffSettlement::where('separation_request_id', $id)->delete();

        return back()->with('success', 'Request deleted successfully.');
    }
}
