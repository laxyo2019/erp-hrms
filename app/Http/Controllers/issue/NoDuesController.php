<?php

namespace App\Http\Controllers\issue;

use Auth;
use Illuminate\Http\Request;
use App\Models\Employees\Hod;
use App\Models\nodues\NoDues;
use App\Models\issue\IssueIndent;
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
        $emp        = EmployeeMast::with(['department'])
                        ->where('user_id', Auth::id())->first();

        $depart_hod = EmployeeMast::where('user_id', $emp->emp_hod)->first();

        $request    = NoDues::where('user_id', Auth::id())->first();

        $hod_approval = NoDuesApproval::with(['employee', 'department'])
                        ->get();

        $items      =   IssueIndent::where('user_id', Auth::id())
                            ->where('received_date', '!=', '')
                            ->where('user_action', '<>', 0)
                            ->where('user_action', '<>', 3)
                            ->get();

        return view('issue.employees.NoDues.create', compact('hod_approval', 'emp', 'request', 'depart_hod', 'items'));
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
        $count = 0;
        while(count($request->item_id) > $count){
            IssueIndent::where('id', $request->item_id[$count])
                ->update([
                    'handover_date' => $request->handover_date[$count],
                    'user_action'   => 2
                ]);

            $count++;
        }

        $nodues_request = NoDues::create([
                                'user_id'       => Auth::id(),
                                'department_id' => $request->depart_id,
                                'date_join'     => $request->date_join,
                                'date_leave'    => $request->date_leave,
                                'posted'        => date('m-d-Y'),
                                'emp_hod'       => $request->depart_head_id
                            ]);
        #Testing

        $emp = EmployeeMast::with(['department'])
                ->where('user_id', Auth::id())->first();

        #Create Nodues Approval Records

        $emphod = EmployeeMast::where('user_id', $emp->emp_hod)->first();

        $hod = Hod::select('user_id as user', 'depart_id as depart')->get();

        $check_hod = Hod::where('user_id', $emp->emp_hod)->first();

        if($check_hod == null){

            $hod_ids = [];

            $i = 0;
            foreach($hod as $index){

                $hod_ids[$i]['user'] = $index->user;
                $hod_ids[$i]['depart'] = $index->depart;

                $i+=1;
            }

            //Preppend Employee's Hod info to global hod's array

            $emp_hod['user'] = $emphod->user_id;
            $emp_hod['depart'] = $emphod->dept_id;

            array_unshift($hod_ids, $emp_hod);


        }else{
            $hod_ids = $hod;
        }

        foreach($hod_ids as $index){
            NoDuesApproval::create([
                'nodues_request_id' =>  $nodues_request->id,
                'hod_user_id'       =>  $index['user'],
                'hod_depart_id'     =>  $index['depart']
            ]);
        }

       return back()->with('success', 'Request has been submitted.');
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

    public function indexNodues(){

        $data = NoDues::with(['employee', 'department'])->get();

        return view('issue.hr..NoDuesListing.index', compact('data'));
    }

    #Show modal for no dues request approval

    public function showNodues(Request $request){

        $nodues = NoDues::with(['employee', 'department'])
                    ->where('id', $request->request_id)->first();


        $hod = NoDuesApproval::with(['employee', 'department'])
               ->where('nodues_request_id', $request->request_id)
               ->get();

        //$hod = Hod::with(['employee', 'department'])->get();

        return view('issue.hr.NoDuesListing.show', compact('nodues', 'hod'));
    }

    public function storeNodues(Request $request){

        #Get all information of no dues reuqest
        $approval = NoDuesApproval::where('nodues_request_id', $request->request_id)
                    ->where('hod_user_id', Auth::id())
                    ->first();

        #Update action and store flag 1 if action is 1 and store 2 if action is 2
        NoDuesApproval::where('nodues_request_id', $request->request_id)
            ->where('hod_user_id', Auth::id())
            ->update([
                'action' => $request->action
            ]);

        $flag = $request->action == 1 ? 1 : 2;

        return $flag;
    }

    public function noduesDetails( $id){

        $nodues = NoDues::where('id', $id)
                    ->with(['employee', 'department'])
                    ->first();
        $employee = EmployeeMast::where('user_id', $nodues->user_id)->first();

        $items = IssueIndent::where('user_id', $nodues->user_id)
                    ->where('received_date', '!=', '')
                    ->where('user_action', '<>', 0)
                    ->get();

        return view('issue.hr.NoDuesListing.details', compact('nodues', 'items'));
    }

}
