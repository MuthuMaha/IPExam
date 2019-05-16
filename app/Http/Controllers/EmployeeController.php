<?php

namespace App\Http\Controllers;
use Auth;
use App\Http\Requests\LoginValidation;
use Carbon\Carbon;
use App\Employee;
use App\Parent_details;
use App\BaseModels\Student;
use App\BaseModels\Campus;
use App\Tparent;
use App\Token;
use App\User;
use Illuminate\Http\Request;
use App\Exam;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\ExamCollection;
use DB;
use File;
class EmployeeController extends Controller
{
   
     public function empshow(LoginValidation $request)
    {
      $res=Employee::login($request);
      return $res;        
    }

  public function emplist(Request $request)
    {
      $res=Employee::select('EMPLOYEE_ID','SURNAME','NAME','USER_NAME','PAYROLL_ID','SUBJECT','DESIGNATION')
              ->where('PAYROLL_ID', '<>', 'null')
              ->where('EMP_TYPE', '=', 'TEACH')
              ->where('STATUS', '=', 'CURRENT')
      				
      				->paginate(10);
      $sub=DB::table('0_subjects')->get();
      $sec=DB::table('t_college_section')
            ->select('SECTION_ID','section_name')
            ->where('section_name','<>',null)
            ->where('COURSE_TRACK_ID','<>',null)
            ->where('section_name','<>','NOT_ALLOTTED')
            ->where('section_name','<>','DROPOUTS')
            ->where('CAMPUS_ID','=',$request->campus_id)
            ->distinct('section_name')
            ->get();
      $result=[
                'Employee'=>$res,
                'Subject'=>$sub,
                'Section'=>$sec,
              ];
      // $result=array_merge($res,$sub,$sec);
      return $result;     
    }
   
}
