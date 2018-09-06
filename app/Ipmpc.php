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
      $path=public_path().'/Result_sheet/MPC/'.$data->CAMPUS_ID.'/'.$data->EXAM_ID.'/'.$data->STUD_ID.'/'.$data->SUBJECT_ID;
    }
    if ($check[0]->GROUP_NAME='BI.P.C')
    {
         $path=public_path().'/Result_sheet/BIPC/'.$data->CAMPUS_ID.'/'.$data->EXAM_ID.'/'.$data->STUD_ID.'/'.$data->SUBJECT_ID;
    }
      // $result=Ipbpc::result_upload($request);
     // return scandir($path);
        $result= [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                    'Image_path'=>glob($path."/*.{jpg,gif,png,bmp}",GLOB_BRACE),
                 ];
        return $result;
    }
    public static function deleteresult($data){
       $path=$data->paths;
       $res=explode(",", $path);
     
        foreach($res as $item=>$value):
            $g=str_replace('"', "", $value);
          if(File::exists($g)){
             unlink($g);
          }
          else{
            $error[]=$g."--this image not found file may deleted already";
               }
        endforeach;
           $result= [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                        'Error_details'=>$error,
                 ];
        return $result;
          
    }
    public static function markDetails($data){

      //declare the variables
      $test_type_id=array();
      $array=array();
      $result=array();
      $total_avg=array();

      //fetch records from table
              $detail[]=DB::table('IP_MPC_Marks')->select('exam_id','PHYSICS','CHEMISTRY','MATHEMATICS','TOTAL','ENGLISH','GK','SEC_RANK', 'CAMP_RANK', 'CITY_RANK', 'DISTRICT_RANK', 'STATE_RANK', 'ALL_INDIA_RANK','MATHEMATICS_RANK', 'PHYSICS_RANK', 'CHEMISTRY_RANK', 'M_RANK', 'P_RANK', 'C_RANK')
              ->where('STUD_ID','=',Auth::id())
              ->where('exam_id','=',$data->EXAM_ID)
              ->get();

              $detail[]=DB::table('IP_BIPC_Marks')->select('exam_id','PHYSICS', 'CHEMISTRY', 'BIOLOGY', 'BOTANY', 'ZOOLOGY', 'ENGLISH', 'GK', 'SEC_RANK', 'CAMP_RANK', 'CITY_RANK', 'DISTRICT_RANK', 'STATE_RANK', 'ALL_INDIA_RANK', 'PHYSICS_RANK', 'CHEMISTRY_RANK', 'BIOLOGY_RANK', 'BOTANY_RANK', 'ZOOLOGY_RANK', 'ENGLISH_RANK', 'GK_RANK', 'M_RANK', 'P_RANK', 'C_RANK')
              ->where('STUD_ID','=',Auth::id())
              ->where('exam_id','=',$data->EXAM_ID)
              ->get();
              if(count($detail[0])==0 && count($detail[1])==0)
              {
                return [
                    'Login' => [
                        'response_message'=>"error student record mot match with our record",
                        'response_code'=>"0",
                        ],
                      ];
              }
      //Fetch column name 
              for ($i=0; $i <=1 ; $i++) { 
      $table='IP_'.str_replace(".","",Auth::user()->GROUP_NAME).'_Marks';

      $name[]=DB::select('SHOW columns FROM '.$table);

                foreach ($detail[$i] as $key => $value) 
                {               
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
        for ($k=0; $k <=count($result)-1 ; $k++) { 
          $f=0;
          for ($p=0; $p <=count($result[0])-1 ; $p++) { 
           $Avg+=$result[$k][$p]->Percentage;
           $f++;
          }
          if($f)
          $total_avg[$fetch_name[$k]]=($Avg/$f);
          $Avg=0;
        }
        return   [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                        'Result'=>$result,
                        'OverAll_Averages'=>$total_avg,
                 ];
    }
    public static function performancechart($data){

      //declare the variables
      $test_type_id=array();
      $array=array();
      $result=array();
      $total_avg=array();

      //fetch records from table
              $detail[]=DB::table('IP_MPC_Marks')->select('exam_id','PHYSICS','CHEMISTRY','MATHEMATICS','TOTAL','ENGLISH','GK','SEC_RANK', 'CAMP_RANK', 'CITY_RANK', 'DISTRICT_RANK', 'STATE_RANK', 'ALL_INDIA_RANK','MATHEMATICS_RANK', 'PHYSICS_RANK', 'CHEMISTRY_RANK', 'M_RANK', 'P_RANK', 'C_RANK')->where('STUD_ID','=',Auth::id())->get();

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
                // ->where("l.test_type_id","=",$data->test_type_id)
               
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
          if($f)
          $total_avg[$fetch_name[$k]]=($Avg/$f);
          $Avg=0;
        }
        return   [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                        'Result'=>$result,
                        'OverAll_Averages'=>$total_avg,
                 ];
    }
}
