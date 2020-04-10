<?php

namespace App\Http\Controllers\recruitment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\recruitment\Candidate;
use Illuminate\Support\Facades\Storage;
use App\Models\recruitment\RecruitRequest;



class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __constructor(){
        $this->middleware('auth');
    }

    public function index($job_id)
    {
        $requirement = RecruitRequest::where('id', $job_id)
                        ->select('id', 'job_title', 'hr_actions')
                        ->first();

        $candidates = Candidate::where('job_title_id', $job_id)
                        ->get();

        return view('recruitment.candidates.index', compact('requirement', 'candidates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = RecruitRequest::where('id', $request->job_title_id)->first();

        if($request->hr_actions == 0){

            /*$this->validate($request, [
            'job_title_id'      => 'required',
            'candidate_name'    => 'required',
            'education_level'   => 'required',
            'contact'           => 'required',
            'email'             => 'email|required',
            'file_path'         => 'required'
             ]);*/

        

            /*** Directory structure ***/

            if($request->hasFile('file_path')){

              $dir      = 'public/'.date("Y").'/'.date("F");
              $file_ext = $request->file('file_path')->extension();
              $filename = $request->job_title_id.'_'.time().'_candidate_CV.'.$file_ext;
              $path     = $request->file('file_path')->storeAs($dir, $filename);

            }

            Candidate::create([
                'job_title_id' => $request->job_title_id,
                'candidate_name' => $request->candidate_name,
                'education_level' => $request->education_level,
                'contact' => $request->contact,
                'alt_contact' => $request->alt_contact,
                'email' => $request->email,
                'resume' => $path,
                'candidate_details' => $request->Candidate_details

            ]);

            return back()->with('success', 'New candidate has been added.');
        }else{
            return back()->with('failed', 'You can\'t add new candidates now.');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function downloadResume($id){

        $candidate = Candidate::find($id);
        return Storage::download('/'.$candidate->resume);
    }


    public function show(Request $request)
    {
        $candidate = Candidate::where('id', $request->id)->first();
        return view('recruitment.candidates.show', compact('candidate'));
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
        $candidate = Candidate::find($id);
        Storage::delete($candidate->resume);
        $candidate->delete();

        return back()->with('success', 'Record has been deleted.');
    }

    public function listing( $id){

        $request    = RecruitRequest::where('id', $id)
                        ->first();

        $candidates = Candidate::where('job_title_id', $id)
                        ->with(['education'])
                        ->get();

        return view('recruitment.candidates.listing', compact('candidates', 'request'));
    }

    public function listingShow( $id){

        $candidate = Candidate::findOrFail($id)
                        ->with(['education'])
                        ->first();

        return view('recruitment.candidates.view', compact('candidate'));
    }

    public function shortlist( $id){

        $candidate = Candidate::where('id', $id)
                        ->update(['recruiter_approval' => 1]);
    }
}
