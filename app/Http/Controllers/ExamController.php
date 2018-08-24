<?php

namespace App\Http\Controllers;
use Auth;
use Carbon\Carbon;
use App\Employee;
use App\Ipexam;
use App\Campusupload;
use App\Ipbpc;
use App\Ipmpc;
use App\Http\Requests\Resultupload;
use App\Ipexamconductedfor;
use App\Token;
use App\User;
use Illuminate\Http\Request;
use App\Exam;
use App\Http\Requests\ExamValidation;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\ExamCollection;
use Illuminate\Database\Eloquent\Builder;
use DB;
use File;
class ExamController extends Controller
{
   
  
    public function createIPExam(ExamValidation $request)
    {
       $create=Ipexam::ipcreate($request);
       return $create;
    }
    public function ipUpdate(Request $request){
        $update=Ipexam::ipupdate($request);
       return $update;
    }
    public function deleteexamdetails(Request $request){
        $update=Ipexam::deleteexamdetails($request);
       return $update;
    }
    public function examdetailcreate(Request $request){
        $update=Ipexam::examdetailcreate($request);
       return $update;
    }
    public function editExam(Request $request){
        $update=Ipexam::editExam($request);
       return $update;
    }
    public function ipeditexamdetails(Request $request){
        $update=Ipexam::ipeditexamdetails($request);
       return $update;
    }
    public function ipdelete(Request $request){
      $d=Campusupload::where('exam_id',$request->route('id'))->get();
      if(count($d)==0){
        $ip_delete=Ipexam::where('exam_id',$request->route('id'))
        ->delete();
        $ip_examcon=Ipexamconductedfor::where('exam_id',$request->route('id'))->delete();
        return ['success'=>['Message'=>'Deleted success']];
      }
      return ['success'=>['Message'=>'Not Deleted because of some upload']];

    }
    // public function ipview(Request $request){
    //     $ip_exam=Ipexam::where('exam_id',$request->exam_id)->get();
    //     $ip_examcon=Ipexamconductedfor::where('exam_id',$request->exam_id)->get();
    //    return ['success'=>['Ip_exam'=>$ip_exam,'Ip_exam_conducted_for'=>$ip_examcon]];
    // }
    public function bipc(Request $request){
    $result_store=Campusupload::result_store($request);
    return $result_store;
    }
    public function bipcedit(Request $request){
    $result_store=Campusupload::result_store($request);
    return $result_store;
    }
    public function bipcdelete(Request $request){
    $result_store=Campusupload::result_delete($request);
    return $result_store;
    }
    public function mpc(Resultupload $request){

      $result=Ipbpc::result_upload($request);
     return $result;


    }
    public function resultimagesview(Request $request){
      $result=Ipmpc::resultview($request);

      return $result;
    }
    public function deleteresult(Request $request){
      $result=Ipmpc::deleteresult($request);

      return $result;
    }
   
}
