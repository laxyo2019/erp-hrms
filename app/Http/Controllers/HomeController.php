<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
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
        //Hide employee leave request menu.
        
        $user = EmployeeMast::with('allotments')
                    ->where('user_id', Auth::id())
                    ->first();

        if(!empty($user)){

            $leave['allotment']  = $user->leave_allotted;
            $leave['reallotment']= $user['allotments'];
            Session::put('leave', $leave);
        }
        return view('home');
    }
}
