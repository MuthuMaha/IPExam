<?php

namespace App\Http\Controllers;
use Auth;
use Carbon\Carbon;
use App\Employee;
use App\Ipexam;
use App\Campusupload;
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
    public function ipview(Request $request){
        $ip_exam=Ipexam::where('exam_id',$request->exam_id)->get();
        $ip_examcon=Ipexamconductedfor::where('exam_id',$request->exam_id)->get();
       return ['success'=>['Ip_exam'=>$ip_exam,'Ip_exam_conducted_for'=>$ip_examcon]];
    }
    public function bipc(Request $request){
 
      Campusupload::updateOrCreate(['CAMPUS_ID'=>$request->CAMPUS_ID,'exam_id'=>$request->EXAM_ID,'section_id'=>$request->section_id,'status'=>$request->status]);
      \App\Ipbpc::updateOrCreate(
    ['CAMPUS_ID' => $request->CAMPUS_ID, 'STUD_ID' => $request->STUD_ID],
    ['exam_id' => $request->EXAM_ID,'PHYSICS'=>$request->PHYSICS, 'CHEMISTRY'=>$request->CHEMISTRY, 'BIOLOGY'=>$request->BIOLOGY, 'BOTANY'=>$request->BOTANY, 'ZOOLOGY'=>$request->ZOOLOGY, 'ENGLISH'=>$request->ENGLISH, 'GK'=>$request->GK, 'TOTAL'=>$request->TOTAL, 'SEC_RANK'=>$request->SEC_RANK, 'CAMP_RANK'=>$request->CAMP_RANK, 'CITY_RANK'=>$request->CITY_RANK, 'DISTRICT_RANK'=>$request->DISTRICT_RANK, 'STATE_RANK'=>$request->STATE_RANK, 'ALL_INDIA_RANK'=>$request->ALL_INDIA_RANK, 'PHYSICS_RANK'=>$request->PHYSICS_RANK, 'CHEMISTRY_RANK'=>$request->CHEMISTRY_RANK, 'BIOLOGY_RANK'=>$request->BIOLOGY_RANK, 'BOTANY_RANK'=>$request->BOTANY_RANK, 'ZOOLOGY_RANK'=>$request->ZOOLOGY_RANK, 'ENGLISH_RANK'=>$request->ENGLISH_RANK, 'GK_RANK'=>$request->GK_RANK, 'M_RANK'=>$request->M_RANK, 'P_RANK'=>$request->P_RANK, 'C_RANK'=>$request->C_RANK, 'MAT1'=>$request->MAT1, 'MAT2'=>$request->MAT1, 'MAT3'=>$request->MAT3, 'PHY1'=>$request->PHY1, 'PHY2'=>$request->PHY2, 'CHE1'=>$request->CHE1, 'CHE2'=>$request->CHE2, 'REG_RANK'=>$request->REG_RANK]
);

      return 'success';


    }
    public function mpc(Resultupload $request){
      $path=public_path().'/Result_sheet/'.$request->Type.'/'.$request->CAMPUS_ID.'/'.$request->EXAM_ID.'/'.$request->STUD_ID.'/'.$request->SUBJECT_ID;
    File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
$images=array();
 if($files=$request->file('files')){
        foreach($files as $file){
            $name=rand().'.'.$file->getClientOriginalExtension();
            $file->move($path,$name);
            $images[]=$name;
        }
    }

     return glob($path."/*.{jpg,gif,png,bmp}",GLOB_BRACE);


    }
   
}
