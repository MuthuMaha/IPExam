<?php

namespace App;
use DB;
use File;
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
       $check=DB::table('IP_Exam_Conducted_For as a')
        ->join('t_course_group as b', 'a.group_id', '=', 'b.GROUP_ID')
        ->select('b.GROUP_NAME')
        ->where('a.exam_id',$data->EXAM_ID)
        ->get();
        $table='IP_'.str_replace(".","",$check[0]->GROUP_NAME).'_Marks';
        $detail=DB::table($table)->where(['CAMPUS_ID'=>$data->CAMPUS_ID,'STUD_ID'=>$data->STUD_ID,'exam_id'=>$data->EXAM_ID]
      )->get();
        $test_type_id=DB::table('IP_Exam_Details')->select('Test_type_id')->where('exam_id',$data->EXAM_ID)->get();
        $max_pass=DB::table('IP_Test_Max_Marks')->where('test_type_id',$test_type_id[0]->Test_type_id)->get();
        $subjects=DB::table('0_subjects')->get();
        
        return [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                        'Exam_details'=>$detail,
                        'Max_Pass_Marks'=>$max_pass,
                        'Subjects'=>$subjects,
                 ];
    }
}
