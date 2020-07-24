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
        return view('birthday.create');
    }

    
    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required','mobile_number'=>'required','date_of_birth'=>'required']);
        $registration_date = date('Y-m-d',strtotime($data['date_of_birth'])) ;
        $date1 = strtotime(date('Y').'-'.date('m-d',strtotime($data['date_of_birth'])));
        $date2 = strtotime(date('Y-m-d'));
                
        if ($date2 >= $date1 ){
            $date = date('Y', strtotime('+1 year')).'-'.date('m-d',strtotime($data['date_of_birth'])) ;
        }   
        else{
            $date = date('Y').'-'.$registration_date->format('m-d') ;
        }   
       $data['next_date'] = $date;
        Birthday::create($data);
        return redirect('birthday_wish');
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
        $registration_date = date('Y-m-d',strtotime($data['date_of_birth'])) ;
        $date1 = strtotime(date('Y').'-'.date('m-d',strtotime($data['date_of_birth'])));
        $date2 = strtotime(date('Y-m-d'));
                
        if ($date2 >= $date1 ){
            $date = date('Y', strtotime('+1 year')).'-'.date('m-d',strtotime($data['date_of_birth'])) ;
        }   
        else{
            $date = date('Y').'-'.date('m-d',strtotime($data['date_of_birth'])) ;
        }   
       $data['next_date'] = $date;
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
        return Excel::download(new UsersExport, 'birthdayPersons.csv');

        return redirect('birthday_wish');
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
