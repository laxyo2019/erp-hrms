<?php

namespace App\Http\Controllers\recruitment;

use Illuminate\Http\Request;
use App\Models\Master\EduLevel;
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

    public function indexHr( $job_id)
    {
        $requirement = RecruitRequest::with(['education'])
                        ->where('id', $job_id)
                        ->select('id', 'job_title', 'hr_actions', 'recruiter_approval')
                        ->first();

        $candidates = Candidate::where('job_title_id', $job_id)
                        ->where('recruiter_approval', '<>', 2)
                        ->get();

        $education = EduLevel::all();
        return view('recruitment.candidates.hr.index', compact('requirement', 'candidates', 'education'));
    }

    public function indexRecruiter( $job_id)
    {
        $requirement = RecruitRequest::with(['education'])
                        ->where('id', $job_id)
                        ->select('id', 'job_title', 'hr_actions', 'recruiter_approval')
                        ->first();

        $candidates = Candidate::where('job_title_id', $job_id)
                        ->where('recruiter_approval', '<>', 2)
                        ->get();


        return view('recruitment.candidates.recruiter.index', compact('requirement', 'candidates'));
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
        $requests = RecruitRequest::where('id', $request->job_title_id)->first();

        if($requests->hr_actions == 0){

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
                'job_title_id'      => $request->job_title_id,
                'candidate_name'    => $request->candidate_name,
                'education_level'   => $request->education_level,
                'contact'           => $request->contact,
                'alt_contact'       => $request->alt_contact,
                'email'             => $request->email,
                'resume'            => $path,
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
        $candidate = Candidate::with(['education'])->where('id', $request->id)->first();
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

        Candidate::where('id', $id)->update(['recruiter_approval' => 1]);
    }

    public function finaliseCandidate( $id){

        Candidate::where('id', $id)->update(['recruiter_approval' => 1]);
    }

    public function joinCandidate( $id){

        if(Candidate::where('id', $id)->first()->recruiter_approval == 1){

            Candidate::where('id', $id)->update(['hr_approval' => 1]);
        }
    }


}
