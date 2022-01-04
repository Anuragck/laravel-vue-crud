<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    //show-index-page
    public function index(){
        return view('index');
    }


    //Student-add
    public function add(Request $request){

        //Form-Validation
        $request->validate([
            'name' => "required",
            'district' => "required",
        ]);

        if($request->id)
            $student=Student::find($request->id);
        else
        $student=new Student;

        $student->name=$request->name;
        $student->district=$request->district;

        $student->save();
        if( $student->save()){
            return 'success';
        }

    }

        //Students-data-get
        public function get(){
            $students=Student::all();
            return $students;
        }


        //Delete-Students
        public function delete(Request $request){

        if($request->id){
            $student=Student::find($request->id);
            $student->delete();

            return 'success';

        }
        }
}
