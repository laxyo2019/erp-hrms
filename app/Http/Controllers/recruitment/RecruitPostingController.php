<?php

namespace App\Http\Controllers\recruitment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\recruitment\RecruitRequest;

class RecruitPostingController extends Controller
{
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __constructor(){
        $this->middleware('auth');
    }

    public function indexSubAdmin()
    {
        $postings = RecruitRequest::all();

        return view('recruitment.posting.index-subadmin', compact('postings'));
    }

    public function indexAdmin()
    {
        $postings = RecruitRequest::where('subadmin_approval', 1)->get();

        return view('recruitment.posting.index-admin', compact('postings'));
        
    }

    public function indexHr()
    {
        $postings = RecruitRequest::where('subadmin_approval', 1)
                        ->where('admin_approval', 1)
                        ->get();

        return view('recruitment.posting.index-hr', compact('postings'));
        
    }

    public function SubAdminApproval(Request $request, $id){

        RecruitRequest::where('id', $id)
            ->update([
                'subadmin_approval' => $request->action
            ]);

        if($request->action == 1){
            $res['flag'] = 1;
            $res['msg'] = 'Request Approved';    
        }else if($request->action == 2){
            $res['flag'] = 2;
            $res['msg']  = 'Request Declined';
        }

        return $res;
    }

    public function AdminApproval(Request $request, $id){

        RecruitRequest::where('id', $id)
            ->update([
                'admin_approval' => $request->action
            ]);

        if($request->action == 1){
            $res['flag'] = 1;
            $res['msg'] = 'Request Approved';    
        }else if($request->action == 2){
            $res['flag'] = 2;
            $res['msg']  = 'Request Declined';
        }

        return $res;
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
        //
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
