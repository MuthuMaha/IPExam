<?php

namespace App\Http\Controllers;
use Auth;
use Carbon\Carbon;
use App\Employee;
use App\Ipexam;
use App\Ipexamconductedfor;
use App\Token;
use App\User;
use Illuminate\Http\Request;
use App\Exam;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\ExamCollection;
use DB;
use File;
class ExamController extends Controller
{
   
  
    public function createIPExam(Request $request)
    {
       $create=Ipexam::ipcreate($request);
       return $create;
    }
    public function ipUpdate(Request $request){
        $update=Ipexam::ipupdate($request);
       return $update;
    }
    public function ipdelete(Request $request){
        $ip_delete=Ipexam::where('exam_id',$request->exam_id)
        ->delete();
        $ip_examcon=Ipexamconductedfor::where('exam_id',$request->exam_id)->delete();
      return ['success'=>['Message'=>'Deleted success']];

    }
    public function ipview(Request $request){
        $ip_exam=Ipexam::where('exam_id',$request->exam_id)->get();
        $ip_examcon=Ipexamconductedfor::where('exam_id',$request->exam_id)->get();
       return ['success'=>['Ip_exam'=>$ip_exam,'Ip_exam_conducted_for'=>$ip_examcon]];
    }
   
}
