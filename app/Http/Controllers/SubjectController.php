<?php

namespace App\Http\Controllers;
use DB;
use App\Ipsection;
use App\Ipexammarks;
use App\Student;
use App\BaseModels\Campus;
use App\Campusupload;
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

       if($request->check=='all')
       {

            $upload=Campusupload::updateorcreate([
                'CAMPUS_ID'=>$request->CAMPUS_ID,
                'section_id'=>$request->SECTION_ID,
                'exam_id'=>$request->EXAM_ID,
                'status'=>'0'
              ]);
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

        }
        // return $student;
      }
      elseif($request->check=='entire'){
        $student=array();
        // $campus_id=array();
        $exam_id=$request->EXAM_ID;
        // $campus_id[]=$request->CAMPUS_ID;
        // return $campus_id;
         $cond=DB::table('IP_Exam_Conducted_For')
                              ->where('exam_id',$request->EXAM_ID)
                              ->get();
            $a=array();
            $b=array();
             foreach ($cond as $key => $value) {
                $b[]='(c.GROUP_ID="'.$value->group_id.'" and c.CLASS_ID="'.$value->classyear_id.'" and c.STREAM_ID="'.$value->stream_id.'" and t_college_section.PROGRAM_ID="'.$value->program_id.'")';


                      }
                    $value=array();
                   
                              $exam_id=$request->EXAM_ID;

          $examlist=Campus::
                    with('city','state','district')
                   ->with(['section'=>function($q) use ($a,$b){    
                   // $q->where('t_college_section.SECTION_ID', '=', DB::table('t_student')->get('SECTION_ID'));
                    if(count($b)!=0){
                     foreach ($b as $key => $value) 
                     {
                        $q->orwhereRaw($value);                  
                      }  
                    }
                    }

                  ])
                   ->with(['check'=>function($q) use ($exam_id){
                    $q->where('exam_id',$exam_id);
                   }])
                   ->whereIn('CAMPUS_ID',$request->CAMPUS_ID)
                    ->distinct()
                    ->get();
                    // return $examlist;        
        foreach ($examlist as $key => $value) 
        {
        foreach ($value->section as $key => $value1) 
        {
                         
              $upload=Campusupload::updateorcreate([
                  'CAMPUS_ID'=>$value->CAMPUS_ID,
                  'section_id'=>$value1->SECTION_ID,
                  'exam_id'=>$request->EXAM_ID,
                  'status'=>'0'
                ]);
        $student=DB::table('t_student as a')
          ->where('a.SECTION_ID','=',$value1->SECTION_ID)->get();

          foreach ($student as $key => $value) 
          {
                $create=Ipexammarks::updateorcreate([
                  'CAMPUS_ID'=>$value1->CAMPUS_ID,
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

          }
        }
      }


      }
      else{
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
      return $request;

    }
    public function notify(Request $request){
      $subject=array();
      $a=array();
      $arr=['PHYSICS','CHEMISTRY','MATHEMATICS','BIOLOGY','BOTANY','ZOOLOGY','ENGLISH','GK'];

      for($i=0;$i<=count($arr)-1;$i++)
      {

         $res=DB::table('IP_Exam_Marks') 
                 ->where($arr[$i],'0.00')
                 ->get(); 

        if(count($res)!=0)
        {

          $a[]=$arr[$i];   

         }

        }

      for($i=0;$i<=count($a)-1;$i++)
      {

        $subject[]=DB::table('0_subjects as a')
                    ->leftjoin('IP_Exam_Section as b','a.subject_id','=','b.SUBJECT_ID')
                    ->leftjoin('t_employee as c','b.EMPLOYEE_ID','c.PAYROLL_ID')
                    ->select('c.MOBILENO','c.PAYROLL_ID')
                    ->where('a.subject_name',$a[$i])
                    ->where('b.SECTION_ID',$request->SECTION_ID)
                    ->get();
      $res=DB::table('t_student as a')
            ->leftjoin('IP_Exam_Marks as b','a.ADM_NO','=','b.STUD_ID')
            ->where('a.SECTION_ID','=',$request->SECTION_ID)
            // ->where('b.exam_id','=',$request->exam_id)
            ->where('b.'.$a[$i],'=','0.00')
            ->select('a.ADM_NO','a.NAME','b.PHYSICS','b.CHEMISTRY','b.MATHEMATICS','b.BIOLOGY','b.BOTANY','b.ZOOLOGY','b.ENGLISH','b.GK')
            ->get();
      }

      return [
              'Subject'=>$subject,
              'Result'=>$res,
              ];

    }
    public function uploadstatus(Request $request){
      $r=Campusupload::uploadstatus($request);
      return $r;
    } 
}
