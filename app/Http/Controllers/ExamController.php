<?php

namespace App\Http\Controllers;
use Auth;
use Carbon\Carbon;
use App\Employee;
use App\Ipexam;
use App\BaseModels\Campus;
use App\Campusupload;
use App\Ipbipc;
use App\Ipmpc;
use App\Query;
use App\Response;
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
// use  App\BaseModels\Campus;
use DB;
use File;
class ExamController extends Controller
{
    private $objFoo;


     public function __construct(Campus $foo){
         $this->objFoo = $foo;
     }

  
    public function createIPExam(Request $request)
    {
       $create=Ipexam::ipcreate($request);
       return $create;
    } 
    public function createIPExamname(Request $request)
    {
       $create=Ipexam::createIPExamname($request);
       return $create;
    } 
    public function queryRise(Request $request)
    {
       $create=Query::queryRise($request);
       return $create;
    }
    public function getqueryRise(Request $request)
    {
       $create=Query::getqueryRise($request);
       return $create;
    }
    public function getqueryList(Request $request)
    {
       $create=Query::getqueryList($request);
       return $create;
    }
    public function updatequery(Request $request)
    {
       $create=Query::updatequery($request);
       return $create;
    }
    public function deleteQuery(Request $request)
    {
       $create=Query::where('query_id',$request->Query_Id)->delete();
          return [
                'Login' => [
                    'response_message'=>"success",
                    'response_code'=>"1",
                    ],
                'Message'=>'Query Deleted Successfully',
            ];
    }
    public function deleteResponse(Request $request)
    {
       $create=Response::where('response_id',$request->Response_Id)->delete();
          return [
                'Login' => [
                    'response_message'=>"success",
                    'response_code'=>"1",
                    ],
                'Message'=>'Response Deleted Successfully',
            ];
    }
    public function queryResponse(Request $request)
    {
       $create=Response::queryResponse($request);
       return $create;
    }
    public function getqueryResponse(Request $request)
    {
       $create=Response::getqueryResponse($request);
       return $create;
    }
    public function getqueryResponseList(Request $request)
    {
       $create=Response::getqueryResponseList($request);
       return $create;
    }
    public function updatequeryResponse(Request $request)
    {
       $create=Response::updatequeryResponse($request);
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
    public function ipdelete(Request $request)
    {    
      $result=Campusupload::ip_delete($request->route('id'));
      return $result;
    }
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
    public function mpc(Request $request){

      $result=Ipbipc::result_upload($request);
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
    public function markDetails(Request $request){
      $result=Ipmpc::markDetails($request);

      return $result;
    }
    public function performancechart(Request $request){
      $result=Ipmpc::performancechart($request);
      return $result;
    }
    public function performancemonth(Request $request){
      $result=Ipmpc::performancemonth($request);
      return $result;
    }
   
    public function test_type(Request $request){
      $result=DB::table('0_test_types')->get();
      return [
                'Login' => [
                    'response_message'=>"success",
                    'response_code'=>"1",
                    ],
                'Result'=>$result,
            ];
    }
    public function result_details(Request $request)
    {      
      $check=DB::table('IP_Exam_Conducted_For as a')
        ->join('t_course_group as b', 'a.group_id', '=', 'b.GROUP_ID')
        ->select('b.GROUP_NAME')
        ->where('a.exam_id',$request->EXAM_ID)
        ->get();
        if(!count($check)){
          return "EXAM_ID WRONG";
        }
         $subjects=DB::table('0_subjects')->get();
         foreach ($subjects as $key => $value) {
          
            if ($check[0]->GROUP_NAME='M.P.C')
            {
              $path=public_path().'/Result_sheet/MPC/'.$request->CAMPUS_ID.'/'.$request->EXAM_ID.'/'.$request->USERNAME.'/'.$value->subject_id;
            }
            if ($check[0]->GROUP_NAME='BI.P.C')
            {
                 $path=public_path().'/Result_sheet/BIPC/'.$request->CAMPUS_ID.'/'.$request->EXAM_ID.'/'.$request->USERNAME.'/'.$value->subject_id;
            }
            // $subjects[$key]->{$value->subject_name}=scandir($path."/");  
            $subjects[$key]->{'result_images'}=str_replace("/var/www/html/","http://175.101.3.68/",glob($path."/*.{jpg,gif,png,bmp}",GLOB_BRACE));  

         }
      // $result=Ipbpc::result_upload($request);
     // return scandir($path);
        // $result= [
        //             'Login' => [
        //                 'response_message'=>"success",
        //                 'response_code'=>"1",
        //                 ],
        //             'Image_path'=>glob($path."/*.{jpg,gif,png,bmp}",GLOB_BRACE),
        //          ];
        // return $result;
     
      $employeelist=Employee::select('DESIGNATION','PAYROLL_ID')
                  ->where('PAYROLL_ID', '<>', 'null')
                  ->where('DESIGNATION', '<>', '')
                  ->where('CAMPUS_ID', '=', $request->CAMPUS_ID)
                  ->distinct('DESIGNATION')
                  ->limit(100)
                    ->get();
       return [
                'Login' => [
                    'response_message'=>"success",
                    'response_code'=>"1",
                    ],
                'Subjects'=>$subjects,
                // 'Image_path'=>$Image_path,
                'Employeelist'=>$employeelist,
            ];
    }
    public function ipview(Request $request)
    {
       $examlist=Ipexam::join('0_test_types as b','IP_Exam_Details.Test_type_id','=','b.test_type_id')
                // ->select('IP_Exam_Details.Date_exam','IP_Exam_Details.Exam_name','IP_Exam_Details.End_Date','IP_Exam_Details.last_date_to_upload','b.test_type_name','IP_Exam_Details.Board')
                ->with('conduct')
                ->paginate(10);
                  return $examlist;
    }
  public function examlist(Request $request)
    {
        if($request->year!='' && $request->group!='' && $request->stream!='' && $request->program!='' && $request->status!=''){
           $examlist=Ipexam::join('IP_Exam_Conducted_For as b','IP_Exam_Details.exam_id','=','b.exam_id')
                  ->leftjoin('IP_Campus_Uploads as c','IP_Exam_Details.exam_id','=','c.exam_id')
                  ->where('b.classyear_id',$request->year)
                  ->where('b.group_id',$request->group)
                  ->where('b.stream_id',$request->stream)
                  ->where('b.program_id',$request->program)
                  ->where('c.status',$request->status)
                  ->distinct()
                  ->paginate(6);
        }
        elseif($request->year!='' && $request->group!=''){
           $examlist=Ipexam::join('IP_Exam_Conducted_For as b','IP_Exam_Details.exam_id','=','b.exam_id')
                  ->leftjoin('IP_Campus_Uploads as c','IP_Exam_Details.exam_id','=','c.exam_id')
                  ->where('b.classyear_id',$request->year)
                  ->where('b.group_id',$request->group)
                  ->distinct()
                  ->paginate(6);
        }
        elseif($request->group!='' && $request->stream!=''){
           $examlist=Ipexam::join('IP_Exam_Conducted_For as b','IP_Exam_Details.exam_id','=','b.exam_id')
                  ->leftjoin('IP_Campus_Uploads as c','IP_Exam_Details.exam_id','=','c.exam_id')                  
                  ->where('b.group_id',$request->group)
                  ->where('b.stream_id',$request->stream)
                  ->distinct()
                  ->paginate(6);
        }
        elseif($request->stream!='' && $request->program!=''){
           $examlist=Ipexam::join('IP_Exam_Conducted_For as b','IP_Exam_Details.exam_id','=','b.exam_id')
                  ->leftjoin('IP_Campus_Uploads as c','IP_Exam_Details.exam_id','=','c.exam_id')
                  ->where('b.stream_id',$request->stream)
                  ->where('b.program_id',$request->program)
                  ->distinct()
                  ->paginate(6);
        }
        elseif($request->program!='' && $request->status!=''){
           $examlist=Ipexam::join('IP_Exam_Conducted_For as b','IP_Exam_Details.exam_id','=','b.exam_id')
                  ->leftjoin('IP_Campus_Uploads as c','IP_Exam_Details.exam_id','=','c.exam_id')
                  ->where('b.program_id',$request->program)
                  ->where('c.status',$request->status)
                  ->distinct()
                  ->paginate(6);
        }
        elseif($request->year!=''){
           $examlist=Ipexam::join('IP_Exam_Conducted_For as b','IP_Exam_Details.exam_id','=','b.exam_id')
                  ->leftjoin('IP_Campus_Uploads as c','IP_Exam_Details.exam_id','=','c.exam_id')
                  ->where('b.classyear_id',$request->year)
                  ->distinct()
                  ->paginate(6);
        }
        elseif($request->group!=''){
           $examlist=Ipexam::join('IP_Exam_Conducted_For as b','IP_Exam_Details.exam_id','=','b.exam_id')
                  ->leftjoin('IP_Campus_Uploads as c','IP_Exam_Details.exam_id','=','c.exam_id')
                   ->where('b.group_id',$request->group)
                   ->distinct()
                  ->paginate(6);
        }
        elseif($request->stream!=''){
           $examlist=Ipexam::join('IP_Exam_Conducted_For as b','IP_Exam_Details.exam_id','=','b.exam_id')
                  ->leftjoin('IP_Campus_Uploads as c','IP_Exam_Details.exam_id','=','c.exam_id')
                   ->where('b.stream_id',$request->stream)
                   ->distinct()
                  ->paginate(6);
        }
        elseif($request->program!=''){
           $examlist=Ipexam::join('IP_Exam_Conducted_For as b','IP_Exam_Details.exam_id','=','b.exam_id')
                  ->leftjoin('IP_Campus_Uploads as c','IP_Exam_Details.exam_id','=','c.exam_id')
                   ->where('b.program_id',$request->program)  
                   ->distinct()                
                  ->paginate(6);
        }
        elseif($request->status!=''){
           $examlist=Ipexam::join('IP_Exam_Conducted_For as b','IP_Exam_Details.exam_id','=','b.exam_id')
                  ->leftjoin('IP_Campus_Uploads as c','IP_Exam_Details.exam_id','=','c.exam_id')
                   ->where('c.status',$request->status)   
                   ->distinct()               
                  ->paginate(6);
        }
        else{
           $examlist=Ipexam::paginate(6);
        }
       return $examlist;
    }

  public function sectionlist(Request $request)
    {          
      $result=Campusupload::sectionlist($request);
      return $result;
    }
   
}
