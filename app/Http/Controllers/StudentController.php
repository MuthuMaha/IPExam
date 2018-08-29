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

<<<<<<< HEAD
    	return Student::written_tests($request->stud_id);
=======
    	return Student::written_tests($request);
>>>>>>> 1be52987cc988fe23f339ff42f266975cc6b1306

    }
}
