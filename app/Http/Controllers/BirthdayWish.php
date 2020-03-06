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
        $data = Birthday::find($id);
       return view('birthday.edit',compact('data'));
    }

   
    public function update(Request $request, $id)
    {
        $data = $request->validate(['name'=>'required','mobile_number'=>'required','date_of_birth'=>'required']);
        Birthday::where('id',$id)->update($data);
        return redirect('birthday_wish');
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
