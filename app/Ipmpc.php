<?php

namespace App;
use DB;
use File;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Ipmpc extends Model
{
    protected $table='IP_MPC_Marks';
    protected $primaryKey='sl';
    public $timestamps=false;
    protected $fillable=['CAMPUS_ID', 'STUD_ID', 'exam_id', 'PHYSICS', 'CHEMISTRY', 'MATHEMATICS', 'TOTAL', 'SEC_RANK', 'CAMP_RANK', 'CITY_RANK', 'DISTRICT_RANK', 'STATE_RANK', 'ALL_INDIA_RANK', 'ENGLISH', 'GK', 'MATHEMATICS_RANK', 'PHYSICS_RANK', 'CHEMISTRY_RANK', 'M_RANK', 'P_RANK', 'C_RANK', 'MAT1', 'MAT2', 'MAT3', 'PHY1', 'PHY2', 'CHE1', 'CHE2', 'REG_RANK', 'CAMPUS' ];

    public static function resultview($data){
      $subject=DB::table('0_subjects')->where('subject_name',Auth::user()->SUBJECT)->get();
  if(!count($subject)){
      return [
                'Login' => [
                    'response_message'=>"login with Teacher Login ID",
                    'response_code'=>"0",
                    ],
            ];
          }
      $check=DB::table('IP_Exam_Conducted_For as a')
        ->join('t_course_group as b', 'a.group_id', '=', 'b.GROUP_ID')
        ->select('b.GROUP_NAME')
        ->where('a.exam_id',$data->EXAM_ID)
        ->get();
        if(!count($check)){
          return "EXAM_ID WRONG";
        }
    if ($check[0]->GROUP_NAME='M.P.C')
    {
      $path=public_path().'/Result_sheet/MPC/'.Auth::user()->CAMPUS_ID.'/'.$data->EXAM_ID.'/'.$data->STUD_ID.'/'.$subject[0]->subject_id;
    }
    if ($check[0]->GROUP_NAME='BI.P.C')
    {
         $path=public_path().'/Result_sheet/BIPC/'.Auth::user()->CAMPUS_ID.'/'.$data->EXAM_ID.'/'.$data->STUD_ID.'/'.$subject[0]->subject_id;
    }
      // $result=Ipbpc::result_upload($request);
     // return scandir($path);
        $result= [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                    'Image_path'=>str_replace("/var/www/html/","http://103.206.115.37/",glob($path."/*.{jpg,gif,png,bmp}",GLOB_BRACE)),
                 ];
        return $result;
    }
    public static function deleteresult($data){

      $subject=DB::table('0_subjects')->where('subject_id',$data->SUBJECT_ID)->get();
        $marks=Ipexammarks::updateOrCreate(
          [
          'CAMPUS_ID'=>$data->CAMPUS_ID, 
          'STUD_ID'=>$data->STUD_ID,
          'exam_id'=>$data->EXAM_ID,
         ],
         [
          strtoupper($subject[0]->subject_name)=>$data->mark,
        ]
      )->get();

      $error=array();
       $path=$data->paths;
       $res=explode(",", $path);
     
        foreach($res as $item=>$value):
            $g=str_replace('"', "", $value);
            $h=str_replace("http://103.206.115.37/","/var/www/html/",$g);
            // return $h;
          if(File::exists($h)){
             unlink($h);
          }
          else{
            $error[]=$g."this image deleted successfully";
               }
        endforeach;
           $result= [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                        'Message'=>$error,
                 ];
        return $result;
          
    }
    public static function markDetails($data){

      //declare the variables
      $test_type_id=array();
      $array=array();
      $result=array();
      $total_avg=array();
      $total_pass_marks="";
      $total_max_marks="";

      //fetch records from table
       if(isset($data->STUD_ID))
              $detail[]=DB::table('IP_Exam_Marks')->select('exam_id','PHYSICS', 'CHEMISTRY', 'MATHEMATICS','BIOLOGY', 'BOTANY', 'ZOOLOGY', 'ENGLISH', 'GK', 'SEC_RANK', 'CAMP_RANK', 'CITY_RANK', 'DISTRICT_RANK', 'STATE_RANK', 'ALL_INDIA_RANK', 'PHYSICS_RANK', 'CHEMISTRY_RANK', 'BIOLOGY_RANK', 'BOTANY_RANK', 'ZOOLOGY_RANK', 'ENGLISH_RANK','MATHEMATICS_RANK', 'GK_RANK', 'M_RANK', 'P_RANK', 'C_RANK','MAT1', 'MAT2', 'MAT3', 'PHY1', 'PHY2', 'CHE1', 'CHE2', 'REG_RANK')
              ->where('STUD_ID','=',$data->STUD_ID)
              ->where('exam_id','=',$data->EXAM_ID)
              ->get();

      if(!isset($data->STUD_ID))
              $detail[]=DB::table('IP_Exam_Marks')
              ->select('exam_id','PHYSICS', 'CHEMISTRY', 'MATHEMATICS','BIOLOGY', 'BOTANY', 'ZOOLOGY', 'ENGLISH', 'GK', 'SEC_RANK', 'CAMP_RANK', 'CITY_RANK', 'DISTRICT_RANK', 'STATE_RANK', 'ALL_INDIA_RANK', 'PHYSICS_RANK', 'CHEMISTRY_RANK', 'BIOLOGY_RANK', 'BOTANY_RANK', 'ZOOLOGY_RANK', 'ENGLISH_RANK','MATHEMATICS_RANK', 'GK_RANK', 'M_RANK', 'P_RANK', 'C_RANK','MAT1', 'MAT2', 'MAT3', 'PHY1', 'PHY2', 'CHE1', 'CHE2', 'REG_RANK')
              ->where('STUD_ID','=',Auth::id())
              ->where('exam_id','=',$data->EXAM_ID)
              ->get();
              
              if(count($detail[0])==0)
              {
                $result[0]="";
                 $total_avg["subject_name"]=array();
                  $total_avg["subject_percentage"]=array();
                  $total_avg["subject_marks"]=array();
                return [
                    'Login' => [
                        'response_message'=>"error student record mot match with our record",
                        'response_code'=>"0",
                        ],
                        'Result'=>'No result',
                        'OverAll_Averages'=>$total_avg,
                        'total'=>'0/0',
                        'Add'=>'0/0',
                      ];
              }
      //Fetch column name  
      $table='IP_Exam_Marks';

      $name[]=DB::select('SHOW columns FROM '.$table);

                foreach ($detail[0] as $key => $value) 
                {               
                  $test_type_id[]=DB::table('IP_Exam_Details')->select('Test_type_id')->where('exam_id',$value->exam_id)->get();

                  $array[]=$value;
                }
              

        //Fetch Max,pass,Obtained mark Details
               foreach ($name[0] as $key => $value) 
               {
              
            $s[$value->Field]=DB::table('0_subjects as s')
                  ->join('IP_Test_Max_Marks as i','i.subject_id','=','s.subject_id')
                  ->select('s.subject_id','s.subject_name','i.max_marks','i.pass_marks'
                    ,'i.test_type_id')
                  ->where('s.subject_name',$value->Field)
                  ->where('i.test_type_id','=',$test_type_id[0][0]->Test_type_id)
                  ->get();  

                  $a=$value->Field;
                  if ($s[$value->Field]->isEmpty()) 
                  { 
                   unset($s[$value->Field]);
                  }
                  if (array_key_exists($value->Field,$s)){
                    $fetch_name[]=$value->Field;

              if(isset($data->STUD_ID))
              $result[]=DB::
                table('IP_Exam_Marks as s')
                ->join('IP_Exam_Details as e','e.exam_id','=','s.exam_id')
                ->join('IP_Test_Max_Marks as l','l.test_type_id','=','e.Test_type_id')
                ->select(DB::raw("(s.".$a."/l.max_marks)*100 as Percentage,s.".$a.",l.max_marks,l.pass_marks"))
                ->where("l.subject_id","=",$s[$value->Field][0]->subject_id)
                ->where("l.test_type_id","=",$data->test_type_id)
                ->where("e.exam_id","=",$data->EXAM_ID)               
                ->Where("s.STUD_ID","=",$data->STUD_ID)              
                ->get();
              if(!isset($data->STUD_ID))
              $result[]=DB::
                table('IP_Exam_Marks as s')
                ->join('IP_Exam_Details as e','e.exam_id','=','s.exam_id')
                ->join('IP_Test_Max_Marks as l','l.test_type_id','=','e.Test_type_id')
                ->select(DB::raw("(s.".$a."/l.max_marks)*100 as Percentage,s.".$a.",l.max_marks,l.pass_marks"))
                ->where("l.subject_id","=",$s[$value->Field][0]->subject_id)
                ->where("l.test_type_id","=",$data->test_type_id)
                ->where("e.exam_id","=",$data->EXAM_ID)               
                ->Where("s.STUD_ID","=",Auth::id())              
                ->get();
              }

        }
       
        //Average calculation
        $Avg=0;
        for ($k=0; $k <=count($result)-1 ; $k++) { 
          $f=0;
          for ($p=0; $p <=count($result[0])-1 ; $p++) { 
           $Avg+=$result[$k][$p]->Percentage;
           $f++;
          }
          if($f){
          $total_avg["subject_name"][$k]=$fetch_name[$k];
          $total_avg["subject_percentage"][$k]=round(($Avg/$f),2);
          $total_avg["subject_marks"][$k]=$result[$k][0]->{$fetch_name[$k]};
            }
          $Avg=0;
        }
       $sumArray=0;
       $sumArray1=0;
        foreach ($result as $k=>$subArray) {
          foreach ($subArray as $id=>$value) {
            $sumArray+=intval($value->max_marks);
          }
        }
        foreach ($result as $k=>$subArray) {
          foreach ($subArray as $id=>$value) {
            if(isset($value->PHYSICS))
            $sumArray1+=intval($value->PHYSICS);
            if(isset($value->CHEMISTRY))
            $sumArray1+=intval($value->CHEMISTRY);
            if(isset($value->MATHEMATICS))
            $sumArray1+=intval($value->MATHEMATICS);
            if(isset($value->BIOLOGY))
            $sumArray1+=intval($value->BIOLOGY);
            if(isset($value->BOTANY))
            $sumArray1+=intval($value->BOTANY);
            if(isset($value->ZOOLOGY))
            $sumArray1+=intval($value->ZOOLOGY);
            if(isset($value->ENGLISH))
            $sumArray1+=intval($value->ENGLISH);
            if(isset($value->GK))
            $sumArray1+=intval($value->GK);
          }
        }
        return   [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                        'Result'=>$result,
                        'OverAll_Averages'=>$total_avg,                        
                        'total'=>$total_pass_marks.'/'.$total_max_marks,
                        'Add'=>$sumArray1.'/'.$sumArray,
                 ];
    }
    public static function performancechart($data){
      if ($data->test_type_id=="") {
         return   [
                    'Login' => [
                        'response_message'=>"test_type_id is required",
                        'response_code'=>"0",
                        ],
                      ];
      }
      //declare the variables
      $test_type_id=array();
      $array=array();
      $result=array();
      $total_avg=array();

      //fetch records from table
              $detail[]=DB::table('IP_Exam_Marks')->select('exam_id','PHYSICS','CHEMISTRY','MATHEMATICS','TOTAL','ENGLISH','GK','SEC_RANK', 'CAMP_RANK', 'CITY_RANK', 'DISTRICT_RANK', 'STATE_RANK', 'ALL_INDIA_RANK','MATHEMATICS_RANK', 'PHYSICS_RANK', 'CHEMISTRY_RANK', 'M_RANK', 'P_RANK', 'C_RANK')->where('STUD_ID','=',Auth::id())->get();

              $detail[]=DB::table('IP_BIPC_Marks')->select('exam_id','PHYSICS', 'CHEMISTRY', 'BIOLOGY', 'BOTANY', 'ZOOLOGY', 'ENGLISH', 'GK', 'SEC_RANK', 'CAMP_RANK', 'CITY_RANK', 'DISTRICT_RANK', 'STATE_RANK', 'ALL_INDIA_RANK', 'PHYSICS_RANK', 'CHEMISTRY_RANK', 'BIOLOGY_RANK', 'BOTANY_RANK', 'ZOOLOGY_RANK', 'ENGLISH_RANK', 'GK_RANK', 'M_RANK', 'P_RANK', 'C_RANK')->where('STUD_ID','=',Auth::id())->get();
              if(count($detail[0])==0 && count($detail[1])==0)
              {
                return [
                    'Login' => [
                        'response_message'=>"error student id mot match with our record",
                        'response_code'=>"0",
                        ],
                      ];
              }
      //Fetch column name 
              for ($i=0; $i <=1 ; $i++) 
              { 
      $table='IP_Exam_Marks';

      $name[]=DB::select('SHOW columns FROM '.$table);

                foreach ($detail[$i] as $key => $value) {
               
                  $test_type_id[]=DB::table('IP_Exam_Details')->select('Test_type_id')->where('exam_id',$value->exam_id)->get();

                  $array[]=$value;
                }
              }

        //Fetch Max,pass,Obtained mark Details
               foreach ($name[0] as $key => $value) 
               {
              
            $s[$value->Field]=DB::table('0_subjects as s')
                  ->join('IP_Test_Max_Marks as i','i.subject_id','=','s.subject_id')
                  ->select('s.subject_id','s.subject_name','i.max_marks','i.pass_marks'
                    ,'i.test_type_id')
                  ->where('s.subject_name',$value->Field)
                  ->where('i.test_type_id','=',$test_type_id[0][0]->Test_type_id)
                  ->get();  

                  $a=$value->Field;
                  if ($s[$value->Field]->isEmpty()) 
                  { 
                   unset($s[$value->Field]);
                }
                  if (array_key_exists($value->Field,$s)){
                    $fetch_name[]=$value->Field;
              $result[]=DB::
                table('IP_Exam_Marks as s')
                ->join('IP_Exam_Details as e','e.exam_id','=','s.exam_id')
                ->join('IP_Test_Max_Marks as l','l.test_type_id','=','e.Test_type_id')
                ->select(DB::raw("(s.".$a."/l.max_marks)*100 as Percentage,s.".$a.",l.max_marks,l.pass_marks"))
                ->where("l.subject_id","=",$s[$value->Field][0]->subject_id)
                ->where("l.test_type_id","=",$data->test_type_id)
               
                ->Where("s.STUD_ID","=",Auth::id())
              
                ->get();
              }
                

        }
        //Average calculation
        $Avg=0;
        $f=0;
        for ($k=0; $k <=count($result)-1 ; $k++) { 
          
          for ($p=0; $p <=count($result[0])-1 ; $p++) { 
           $Avg+=$result[$k][$p]->Percentage;
           $f++;
          }
          // $total_avg[$fetch_name[$k]]=($Avg/$f);
         if($f){
          $total_avg["subject_name"][$k]=$fetch_name[$k];
          $total_avg["subject_percentage"][$k]=round(($Avg/$f),2);
            }
          $Avg=0;
        }
       if(!$f){
        $total_avg["subject_name"]=array();
        $total_avg["subject_percentage"]=array();
      }

       $sumArray=0;
       $sumArray1=0;
        foreach ($result as $k=>$subArray) {
          foreach ($subArray as $id=>$value) {
            $sumArray+=intval($value->max_marks);
          }
        }
        foreach ($result as $k=>$subArray) {
          foreach ($subArray as $id=>$value) {
            if(isset($value->PHYSICS))
            $sumArray1+=intval($value->PHYSICS);
            if(isset($value->CHEMISTRY))
            $sumArray1+=intval($value->CHEMISTRY);
            if(isset($value->MATHEMATICS))
            $sumArray1+=intval($value->MATHEMATICS);
            if(isset($value->BIOLOGY))
            $sumArray1+=intval($value->BIOLOGY);
            if(isset($value->BOTANY))
            $sumArray1+=intval($value->BOTANY);
            if(isset($value->ZOOLOGY))
            $sumArray1+=intval($value->ZOOLOGY);
            if(isset($value->ENGLISH))
            $sumArray1+=intval($value->ENGLISH);
            if(isset($value->GK))
            $sumArray1+=intval($value->GK);
          }
        }
        return   [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                        // 'Result'=>$result,
                        'Averages'=> (array)$total_avg,
                        'Total'=>$sumArray1.'/'.$sumArray,
                 ];
    }
    public static function performancemonth($data){
       if (!$data->test_type_id) {
         return   [
                    'Login' => [
                        'response_message'=>"test_type_id is required",
                        'response_code'=>"0",
                        ],
                      ];
      }
      //declare the variables
      $test_type_id=array();
      $array=array();
      $result=array();
      $total_avg=array();

            $dateValue = strtotime($data->test_date);

            $yr = date("m-Y", $dateValue); 
      //fetch records from table
              $detail[]=DB::table('IP_MPC_Marks as a')
                          ->join('IP_Exam_Details as b','b.exam_id','=','a.exam_id')
                          ->select('a.exam_id','a.PHYSICS','a.CHEMISTRY','a.MATHEMATICS','a.TOTAL','a.ENGLISH','a.GK','a.SEC_RANK', 'a.CAMP_RANK', 'a.CITY_RANK', 'a.DISTRICT_RANK', 'a.STATE_RANK', 'a.ALL_INDIA_RANK','a.MATHEMATICS_RANK', 'a.PHYSICS_RANK', 'a.CHEMISTRY_RANK', 'a.M_RANK', 'a.P_RANK', 'a.C_RANK')
                          ->where('a.STUD_ID','=',Auth::id())
                          ->where('b.Date_exam','like','%'.$yr)
                          ->get();

              $detail[]=DB::table('IP_BIPC_Marks as a')
                          ->join('IP_Exam_Details as b','b.exam_id','=','a.exam_id')
                          ->select('a.exam_id','a.PHYSICS', 'a.CHEMISTRY', 'a.BIOLOGY', 'a.BOTANY', 'a.ZOOLOGY', 'a.ENGLISH', 'a.GK', 'a.SEC_RANK', 'a.CAMP_RANK', 'a.CITY_RANK', 'a.DISTRICT_RANK', 'a.STATE_RANK', 'a.ALL_INDIA_RANK', 'a.PHYSICS_RANK', 'a.CHEMISTRY_RANK', 'a.BIOLOGY_RANK', 'a.BOTANY_RANK', 'a.ZOOLOGY_RANK', 'a.ENGLISH_RANK', 'a.GK_RANK', 'a.M_RANK', 'a.P_RANK', 'a.C_RANK')
                          ->where('a.STUD_ID','=',Auth::id())                          
                          ->where('b.Date_exam','like','%'.$yr)
                          ->get();
              if(count($detail[0])==0 && count($detail[1])==0)
              {
                return [
                    'Login' => [
                        'response_message'=>"error student id mot match with our record",
                        'response_code'=>"0",
                        ],
                      ];
              }
      //Fetch column name 
              for ($i=0; $i <=1 ; $i++) 
              { 
      $table='IP_'.str_replace(".","",Auth::user()->GROUP_NAME).'_Marks';

      $name[]=DB::select('SHOW columns FROM '.$table);

                foreach ($detail[$i] as $key => $value) {
               
                  $test_type_id[]=DB::table('IP_Exam_Details')->select('Test_type_id')->where('exam_id',$value->exam_id)->get();

                  $array[]=$value;
                }
              }

        //Fetch Max,pass,Obtained mark Details
               foreach ($name[0] as $key => $value) 
               {
              
            $s[$value->Field]=DB::table('0_subjects as s')
                  ->join('IP_Test_Max_Marks as i','i.subject_id','=','s.subject_id')
                  ->select('s.subject_id','s.subject_name','i.max_marks','i.pass_marks'
                    ,'i.test_type_id')
                  ->where('s.subject_name',$value->Field)
                  ->where('i.test_type_id','=',$test_type_id[0][0]->Test_type_id)
                  ->get();  

                  $a=$value->Field;
                  if ($s[$value->Field]->isEmpty()) 
                  { 
                   unset($s[$value->Field]);
                }
                  if (array_key_exists($value->Field,$s)){
                    $fetch_name[]=$value->Field;
              $result[]=DB::
                table('IP_MPC_Marks as s')
                ->join('IP_Exam_Details as e','e.exam_id','=','s.exam_id')
                ->join('IP_Test_Max_Marks as l','l.test_type_id','=','e.Test_type_id')
                ->select(DB::raw("(s.".$a."/l.max_marks)*100 as Percentage,s.".$a.",l.max_marks,l.pass_marks"))
                ->where("l.subject_id","=",$s[$value->Field][0]->subject_id)
                ->where("l.test_type_id","=",$data->test_type_id)
               
                ->Where("s.STUD_ID","=",Auth::id())
              
                ->get();
              }
                

        }
        //Average calculation
        $Avg=0;
          $f=0;
        for ($k=0; $k <=count($result)-1 ; $k++) { 
          for ($p=0; $p <=count($result[0])-1 ; $p++) { 
           $Avg+=$result[$k][$p]->Percentage;
           $f++;
          }
          if($f)
          // $total_avg[$fetch_name[$k]]=($Avg/$f);
             if($f){
          $total_avg["subject_name"][$k]=$fetch_name[$k];
          $total_avg["subject_percentage"][$k]=round(($Avg/$f),2);
            }
          $Avg=0;
        }

       $sumArray=0;
       $sumArray1=0;
        foreach ($result as $k=>$subArray) {
          foreach ($subArray as $id=>$value) {
            $sumArray+=intval($value->max_marks);
          }
        }
        foreach ($result as $k=>$subArray) {
          foreach ($subArray as $id=>$value) {
            if(isset($value->PHYSICS))
            $sumArray1+=intval($value->PHYSICS);
            if(isset($value->CHEMISTRY))
            $sumArray1+=intval($value->CHEMISTRY);
            if(isset($value->MATHEMATICS))
            $sumArray1+=intval($value->MATHEMATICS);
            if(isset($value->ENGLISH))
            $sumArray1+=intval($value->ENGLISH);
          }
        }
        return   [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                        // 'Result'=>$result,
                        'OverAll_Averages'=>$total_avg,
                        'Total'=>$sumArray1.'/'.$sumArray,
                 ];
    }
}
