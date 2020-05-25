<?php

namespace App\Http\Controllers\recruitment;

use Auth;
use Illuminate\Http\Request;
use App\Models\Master\EmpType;
use App\Models\Master\CompMast;
use App\Models\Master\DeptMast;
use App\Models\Master\ExpLevel;
use App\Models\Master\EduLevel;
use App\Http\Controllers\Controller;
use App\Models\recruitment\Candidate;
use App\Models\Master\EmployementType;
use App\Models\recruitment\RecruitRequest;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __constructor(){
        $this->middleware('auth');
    }

    public function index()
    {
        $indexes = RecruitRequest::with(['company', 'department', 'employement', 'experience', 'education'])
                    ->where('requested_by', Auth::id())
                        ->get();

        return view('recruitment.index', compact('indexes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $comps          = CompMast::all();
        $departments    = DeptMast::all();
        $eduLevels      = EduLevel::all();
        $expLevels      = ExpLevel::all();
        $empTypes       = EmployementType::all();

        return view('recruitment.create', compact('comps', 'departments', 'empTypes', 'eduLevels', 'expLevels'));
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
            'job_title'         => 'required',
            'company_name'      => 'required',
            'city'              => 'required',
            'employement_type'  => 'required',
            'department'        => 'required',
            'from'             => 'required|date',
            'to'               => 'required|date|after:from',
            'job_description'   => 'required',
            ],
            [
                'to.after' => 'This date should be greater.'
            ]
        );

        RecruitRequest::create([
            'requested_by'          => Auth::id(),
            'job_title'             => $request->job_title,
            'comp_id'               => $request->company_name,
            'job_description'       => $request->job_description,
            'from'                  => $request->from,
            'to'                    => $request->to,
            'city'                  => $request->city,
            'postal_code'           => $request->postal_code,
            'depart_id'             => $request->department,
            'employement_type_id'   => $request->employement_type,
            'experience_level_id'   => $request->experience_level,
            'education_level_id'    => $request->education_level 
        ]);

        return redirect()->route('recruitment.index')->with('success', 'Request Generated succesfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request = RecruitRequest::findOrFail($id)
                        ->with(['company', 'department', 'employement', 'experience', 'education'])
                        ->first();

        return view('recruitment.show', compact('request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $request = RecruitRequest::find($id);

        if($request->subadmin_approval != 0){
            $comps          = CompMast::all();
            $departments    = DeptMast::all();
            $eduLevels      = EduLevel::all();
            $expLevels      = ExpLevel::all();
            $empTypes       = EmployementType::all();

            return view('recruitment.edit', compact('request', 'comps', 'departments', 'empTypes', 'eduLevels', 'expLevels'));
        }else{

        
        }
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
            'job_title'         => 'required',
            'company_name'      => 'required',
            'city'              => 'required',
            'employement_type'  => 'required',
            'department'        => 'required',
            'job_description'   => 'required',

        ]);

        RecruitRequest::where('id', $id)
            ->update([
                'job_title'             => $request->job_title,
                'comp_id'               => $request->company_name,
                'job_description'       => $request->job_description,
                'from'                  => $request->from,
                'to'                    => $request->to,
                'city'                  => $request->city,
                'postal_code'           => $request->postal_code,
                'depart_id'             => $request->department,
                'employement_type_id'   => $request->employement_type,
                'experience_level_id'   => $request->experience_level,
                'education_level_id'    => $request->education_level
            ]);


        return redirect()->route('recruitment.index')->with('success', 'Request Generated succesfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RecruitRequest::where('id', $id)
            ->delete();

        return back()->with('success', 'Request Deleted Succesfully.');
    }


    public function apporvedByRecruiter( $id){

        $request = RecruitRequest::where('id', $id)->first();

        if($request->recruiter_approval == 0){

            RecruitRequest::where('id', $id)
                ->update(['recruiter_approval' => 1]);

            Candidate::where('job_title_id', $id)
                    ->where('recruiter_approval', 0)
                    ->update(['recruiter_approval' => 2]);
        }else{
            return false;
        }

    }

    public function closeRequest( $id){

        RecruitRequest::where('id', $id)->update(['hr_actions' => 3]);
    }
}
