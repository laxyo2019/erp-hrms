<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use App\Models\Birthday;
use Maatwebsite\Excel\Facades\Excel;


class BirthdayWish extends Controller
{
    
    public function index()
    {
        $data = Birthday::all();
        return view('birthday.index',compact('data'));
    }

   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        Birthday::destroy($id);
        return redirect('birthday_wish');
    }

    public function import(Request $request) 
    { 
        $data = Excel::import(new UsersImport,$request->file('import'));
        return redirect('birthday_wish');
    }


    public function export(Request $request) 
    {
        $data = Excel::download(new UsersExport, 'birthdayPersons.xlsx');
        return redirect('birthday_wish');
    }
}
