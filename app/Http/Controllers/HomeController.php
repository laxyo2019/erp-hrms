<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use Illuminate\Http\Request;
use App\Models\Employees\LeaveApply;
use App\Models\Employees\EmployeeMast ;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Employees
        $emp_count = EmployeeMast::count();

        //Leave Requests (Pending)
        $leave_req = LeaveApply::where('1', 1);

        //return $employees;
        //Hide employee leave request menu.
        
        $user = EmployeeMast::with('allotments')
                    ->where('user_id', Auth::id())
                    ->first();

        if(!empty($user)){

            $leave['allotment']  = $user->leave_allotted;
            $leave['reallotment']= $user['allotments'];
            Session::put('leave', $leave);
        }
        return view('home', compact('emp_count'));
    }
}
