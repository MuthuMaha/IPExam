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
    $check=array();

    $a=Campusupload::select('exam_id')->distinct()->get();
    foreach ($a as $key => $value) {
      $check[]=$value->exam_id;
    }
      $y=$request->year;
      $g=$request->group;
      $s=$request->stream;
      $p=$request->program;
      $st=$request->status;
        // if($request->status==''){

           $examlist1=Ipexam::
                      join('0_test_types as b','b.test_type_id','=','IP_Exam_Details.Test_type_id')
                      ->with('upload'); 
                      // ->load('status')
                      // ->paginate(6);
                    // }
        if($request->status==1){
            // $examlist1=Ipexam::
            //           join('0_test_types as b','b.test_type_id','=','IP_Exam_Details.Test_type_id')
            //           ->with('upload') 
                      // ->load('status')
                      $examlist1->whereIn('IP_Exam_Details.exam_id',$check);              
                      // ->paginate(6);
        }
        if($request->status==2){
            // $examlist1=Ipexam::
            //           join('0_test_types as b','b.test_type_id','=','IP_Exam_Details.Test_type_id')
            //           ->with('upload') 
                      // ->load('status')
                      $examlist1->whereNotIn('IP_Exam_Details.exam_id',$check);               

                      // ->paginate(6);
        }
        $examlist1=$examlist1->paginate(6);
        if($request->year!='' || $request->group!='' || $request->stream!='' || $request->program!=''){        
        // if($request->status==2 || $request->status==''){
        $examlist1=Ipexam::
                  join('IP_Exam_Conducted_For as b','IP_Exam_Details.exam_id','=','b.exam_id')
                  // ->join('IP_Campus_Uploads as c','IP_Exam_Details.exam_id','=','c.exam_id')
                  ->join('0_test_types as d','d.test_type_id','=','IP_Exam_Details.Test_type_id')
                    ->with('upload') 
                    // ->load('status') 
                   ->where('b.classyear_id',$y)
                   ->where('b.group_id',$g)
                   ->where('b.stream_id',$s)
                   ->where('b.program_id',$p)
                  ->distinct();
                  // ->paginate(6);       
        // }

        if($request->status==1){
        
        // $examlist1=Ipexam::
        //           join('IP_Exam_Conducted_For as b','IP_Exam_Details.exam_id','=','b.exam_id')
        //           // ->join('IP_Campus_Uploads as c','IP_Exam_Details.exam_id','=','c.exam_id')
        //           ->join('0_test_types as d','d.test_type_id','=','IP_Exam_Details.Test_type_id')
        //             ->with('upload') 
        //             // ->load('status') 
        //            ->where('b.classyear_id',$y)
        //            ->where('b.group_id',$g)
        //            ->where('b.stream_id',$s)
        //            ->where('b.program_id',$p)
                    $examlist1->whereIn('IP_Exam_Details.exam_id',$check);                  
                  // ->distinct()
                  // ->paginate(6);
        }
        if($request->status==2){
        
        // $examlist1=Ipexam::
        //           join('IP_Exam_Conducted_For as b','IP_Exam_Details.exam_id','=','b.exam_id')
        //           // ->join('IP_Campus_Uploads as c','IP_Exam_Details.exam_id','=','c.exam_id')
        //           ->join('0_test_types as d','d.test_type_id','=','IP_Exam_Details.Test_type_id')
        //             ->with('upload')  
        //             // ->load('status')
        //            ->where('b.classyear_id',$y)
        //            ->where('b.group_id',$g)
        //            ->where('b.stream_id',$s)
        //            ->where('b.program_id',$p)
                    $examlist1->whereNotIn('IP_Exam_Details.exam_id',$check);                   
                  // ->distinct()
                  // ->paginate(6);
        }
         $examlist1= $examlist1->paginate(6);

        }
        foreach ($examlist1 as $value) {

        $object = new \stdClass(); 
        $object->exam_id = $value->exam_id;
        $object->campus_id = $value->CAMPUS_ID;
        $object->status = '';
         $cond=DB::table('IP_Exam_Conducted_For')
                              ->where('exam_id',$value->exam_id)
                              ->get();
            $a=array();
            $b=array();
             foreach ($cond as $key1 => $value1) {

                $b[]='(c.GROUP_ID="'.$value1->group_id.'" and c.CLASS_ID="'.$value1->classyear_id.'" and c.STREAM_ID="'.$value1->stream_id.'" and t_college_section.PROGRAM_ID="'.$value1->program_id.'")';


                      }
      $campus=Campusupload::select('SECTION_ID')->where('exam_id',$value->exam_id)->distinct()->get();
        if(array_sum(Campusupload::total($b,$value->exam_id)['cal'])==count($campus)){
          if(array_sum(Campusupload::total($b,$value->exam_id)['cal'])!=0 && count($campus)!=0)
         $value->{'complete'}=1;
          else
         $value->{'complete'}=0;

        }
       else{
         $value->{'complete'}=0;
       }


        }
       // $examlist1= in_array(1, (array) $examlist1);
        $group=DB::table('t_course_group')->select('GROUP_ID','GROUP_NAME')->get();
        $stream=DB::table('t_stream')->select('STREAM_ID','STREAM_NAME')->get();
        $classyear=DB::table('t_study_class')->select('CLASS_ID','CLASS_NAME')->get();
        $program=DB::table('t_program_name')->select('PROGRAM_ID','PROGRAM_NAME')->get();
       return [
                'Exam'=>$examlist1,
                'Group'=>$group,
                'Stream'=>$stream,
                'Class'=>$classyear,
                'Program'=>$program,
            ];
    }

  public function sectionlist(Request $request)
    {          
      $result=Campusupload::sectionlist($request);
      return $result;
    }
  public function skipsection(Request $request)
    {          
      $result=Campusupload::skipsection($request);
      return $result;
    }
  public function campsection(Request $request)
    {          
      $result=Campusupload::campsection($request);
      return $result;
    }
  public function examdelete(Request $request)
    {          
      $result=Campusupload::where('exam_id',$request->exam_id)->delete();
      return $result;
    }
   
}
