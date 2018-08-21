<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BaseModels\Student;

use App\Http\Resources\Profile as ProfileResource;

class StudentController extends Controller
{
    //
    public function profile_details(Request $request){

         return new ProfileResource(Student::profile($request->stud_id));

    }

    public function written_tests(Request $request){

    	return Student::written_tests();

    }
}
