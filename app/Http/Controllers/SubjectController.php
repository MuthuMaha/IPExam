<?php

namespace App\Http\Controllers;
use DB;
use App\Ipsection;
use App\Ipexammarks;
use App\Student;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
   
     public function sublist(Request $request)
    {
      $res=DB::table('IP_Exam_Section as a')
      		->join('0_subjects as b','b.subject_id','=','a.SUBJECT_ID')
      		->join('t_college_section as c','c.SECTION_ID','=','a.SECTION_ID')
      		->where('EMPLOYEE_ID','=',$request->PAYROLL_ID)
          ->select('id','subject_name','section_name')
      		->get();
      return $res;        
    }
     public function subadd(Request $request)
    {
      $add=Ipsection::create([
        'EMPLOYEE_ID'=>$request->EMPLOYEE_ID,
        'SUBJECT_ID'=>$request->SUBJECT_ID,
        'SECTION_ID'=>$request->SECTION_ID,
      ]);
      $res=DB::table('IP_Exam_Section as a')
          ->join('0_subjects as b','b.subject_id','=','a.SUBJECT_ID')
          ->join('t_college_section as c','c.SECTION_ID','=','a.SECTION_ID')
          ->where('EMPLOYEE_ID','=',$request->EMPLOYEE_ID)
          ->get();
      return $res;
    }
     public function subupdate(Request $request)
    {
      $add=Ipsection::where('id', $request->update)
          ->update(['SUBJECT_ID' =>$request->SUBJECT_ID,'SECTION_ID' =>$request->SECTION_ID]);

      $res=DB::table('IP_Exam_Section as a')
          ->join('0_subjects as b','b.subject_id','=','a.SUBJECT_ID')
          ->join('t_college_section as c','c.SECTION_ID','=','a.SECTION_ID')
          ->where('EMPLOYEE_ID','=',$request->EMPLOYEE_ID)
          ->get();
      return $res;
    }
     public function subdelete(Request $request)
    {
      $add=Ipsection::where('id', $request->id)
          ->delete();

      $res=DB::table('IP_Exam_Section as a')
          ->join('0_subjects as b','b.subject_id','=','a.SUBJECT_ID')
          ->join('t_college_section as c','c.SECTION_ID','=','a.SECTION_ID')
          ->where('EMPLOYEE_ID','=',$request->EMPLOYEE_ID)
          ->get();
      return $res;
    }
     public function studlist(Request $request)
    {
      $last_date_to_upload=DB::table('IP_Exam_Details')
                            ->select('last_date_to_upload')
                            ->where('exam_id','=',$request->exam_id)
                            ->get();
      $subject=DB::select("SHOW COLUMNS FROM esaplive.IP_Exam_Marks;");
      $res=DB::table('t_student as a')
          ->leftjoin('IP_Exam_Marks as b','a.ADM_NO','=','b.STUD_ID')
        //     ->join('IP_Exam_Marks as b', function($join)
        // {
        //     $join->on('a.ADM_NO','=','b.STUD_ID')->orOn('a.ADM_NO','!=','b.STUD_ID');
        // })
          ->where('a.SECTION_ID','=',$request->SECTION_ID)
      		// ->where('b.exam_id','=',$request->exam_id)
      		->paginate(10);
      return  [
                'Student'=>$res,
                'Subject'=>$subject,
                'end'=>$last_date_to_upload,
               ];
    }
    public function updatemanage(Request $request){

      $arr=['PHYSICS','CHEMISTRY','MATHEMATICS','BIOLOGY','BOTANY','ZOOLOGY','ENGLISH','GK'];
 if($request->check=='all' && $request->SECTION_ID!="")
 {
      $student=DB::table('t_student')->where('SECTION_ID',$request->SECTION_ID)->get();

  foreach ($student as $key => $value) 
  {
        $create=Ipexammarks::updateorcreate([
          'CAMPUS_ID'=>$request->CAMPUS_ID,
          'STUD_ID'=>$value->ADM_NO,
          'exam_id'=>$request->EXAM_ID,
        ],[
          'PHYSICS'=>'AB',
          'CHEMISTRY'=>'AB',
          'MATHEMATICS'=>'AB',
          'BIOLOGY'=>'AB',
          'BOTANY'=>'AB',
          'ZOOLOGY'=>'AB',
          'ENGLISH'=>'AB',
          'GK'=>'AB',
        ]);

  }}
      if(!isset($request->sl)){
        $create=Ipexammarks::updateorcreate([
          'CAMPUS_ID'=>$request->CAMPUS_ID,
          'STUD_ID'=>$request->STUD_ID,
          'exam_id'=>$request->EXAM_ID,
        ],[
          'PHYSICS'=>'AB',
          'CHEMISTRY'=>'AB',
          'MATHEMATICS'=>'AB',
          'BIOLOGY'=>'AB',
          'BOTANY'=>'AB',
          'ZOOLOGY'=>'AB',
          'ENGLISH'=>'AB',
          'GK'=>'AB',
        ]);
      }
      for($i=0;$i<=count($arr)-1;$i++){

      if($request->check!='all') { 
        $res=DB::table('IP_Exam_Marks') 
                 ->where($arr[$i],'') 
                 ->where('sl',$request->sl)
                 ->update([$arr[$i]=>'AB']); 

               }

       if($request->check=='all') { 
         $res=DB::table('IP_Exam_Marks') 
                 ->where($arr[$i],'')
                 ->update([$arr[$i]=>'AB']); 
       }
             }
      return $request->sl;

    }
    public function notify(Request $request){
      $a=array();
      $arr=['PHYSICS','CHEMISTRY','MATHEMATICS','BIOLOGY','BOTANY','ZOOLOGY','ENGLISH','GK'];

      for($i=0;$i<=count($arr)-1;$i++)
      {

         $res=DB::table('IP_Exam_Marks') 
                 ->where($arr[$i],'')
                 ->get(); 

        if(count($res)!=0)
        {

          $a[]=$arr[$i];   

         }

        }

      for($i=0;$i<=count($a)-1;$i++)
      {

        $subject[]=DB::table('0_subjects as a')
                    ->join('IP_Exam_Section as b','a.subject_id','=','b.SUBJECT_ID')
                    ->join('t_employee as c','b.EMPLOYEE_ID','c.PAYROLL_ID')
                    ->select('c.MOBILENO','c.PAYROLL_ID')
                    ->where('a.subject_name',$a[$i])
                    ->where('b.SECTION_ID',$request->SECTION_ID)
                    ->get();
      }

      $res=DB::table('t_student as a')
            ->join('IP_Exam_Marks as b','a.ADM_NO','=','b.STUD_ID')
            ->where('a.SECTION_ID','=',$request->SECTION_ID)
            ->where('b.exam_id','=',$request->exam_id)
            ->select('a.ADM_NO','a.NAME','b.PHYSICS','b.CHEMISTRY','b.MATHEMATICS','b.BIOLOGY','b.BOTANY','b.ZOOLOGY','b.ENGLISH','b.GK')
            ->get();
      return [
              'Subject'=>$subject,
              'Result'=>$res,
              ];

    }
}
