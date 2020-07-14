<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use App\Exports\BirthdayExports;
use App\Models\Birthday;
use Maatwebsite\Excel\Facades\Excel;
use App\MessageFormate;


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

    public function export() 
    {
        // return Birthday::all();
        return Excel::download(new BirthdayExports, 'birthdayPersons.xlsx');

       // return redirect('birthday_wish');
    }

    public function getMessage(){
        $data = MessageFormate::all();
        return view('message.index',compact('data'));
    }

    public function create_message(){
       return view('message.create');
    }

    public function edit_message($id){
        $data = MessageFormate::find($id);
       return view('message.edit',compact('data'));
    }

    public function save_message(Request $request){
       $data = $request->validate(['message'=>'required']);
       MessageFormate::create($data);
       return redirect('get_message');
    }

    public function update_message(Request $request,$id){
        $data = $request->validate(['message'=>'required']);
        MessageFormate::where('id',$id)->update($data);
        return redirect('get_message');   
    }
}
