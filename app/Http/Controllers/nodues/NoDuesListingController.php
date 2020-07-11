<?php

namespace App\Http\Controllers\nodues;

use Auth;
use App\Models\NoDues;
use Illuminate\Http\Request;
use App\Models\Employees\Hod;
use App\Http\Controllers\Controller;
use App\Models\Employees\EmployeeMast;


class NoDuesListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = NoDues::with(['employee', 'department'])->get();

        //dd($hod[0]->employee->emp_name);

        return view('nodues.listing.index', compact('request'));
    }

    public function indexHod()
    {
        $request = NoDues::with(['employee', 'department'])->get();

        return view('nodues.listing.index', compact('request'));
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
        $logged_user = EmployeeMast::where('user_id', Auth::id())->first();
        //dd(Auth::id());
        $req = NoDues::where('id', $request->id)->first();
        

    }

    public function storeHod(Request $request)
    {
        return 685342;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $nodues = NoDues::with(['employee', 'department'])
                    ->where('id', $request->request_id)->first();

        $hod = Hod::with(['employee', 'department'])->get();

        return view('nodues.listing.show', compact('nodues', 'hod'));

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
