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

      $name=DB::select('SHOW columns FROM '.$table);

      $test_type_id=DB::table('IP_Exam_Details')->select('Test_type_id')->where('exam_id',$data->EXAM_ID)->get();

      if(str_replace(".","",$check[0]->GROUP_NAME)=="MPC")

              $detail=DB::table($table)->select('PHYSICS','CHEMISTRY','MATHEMATICS','TOTAL','ENGLISH','GK','SEC_RANK', 'CAMP_RANK', 'CITY_RANK', 'DISTRICT_RANK', 'STATE_RANK', 'ALL_INDIA_RANK','MATHEMATICS_RANK', 'PHYSICS_RANK', 'CHEMISTRY_RANK', 'M_RANK', 'P_RANK', 'C_RANK')->where(['STUD_ID'=>$data->STUD_ID,'exam_id'=>$data->EXAM_ID]
            )->get();

        else  
              $detail=DB::table($table)->select('PHYSICS', 'CHEMISTRY', 'BIOLOGY', 'BOTANY', 'ZOOLOGY', 'ENGLISH', 'GK', 'SEC_RANK', 'CAMP_RANK', 'CITY_RANK', 'DISTRICT_RANK', 'STATE_RANK', 'ALL_INDIA_RANK', 'PHYSICS_RANK', 'CHEMISTRY_RANK', 'BIOLOGY_RANK', 'BOTANY_RANK', 'ZOOLOGY_RANK', 'ENGLISH_RANK', 'GK_RANK', 'M_RANK', 'P_RANK', 'C_RANK')->where(['STUD_ID'=>$data->STUD_ID,'exam_id'=>$data->EXAM_ID]
            )->get();

           foreach ($detail[0] as $key => $value)
          {
              $array[$key] = $value;
          }
          foreach ($name as $key => $value) {
              $s[$value->Field][0] = (object)array();

            $s[$value->Field]=DB::table('0_subjects as s')
                  ->join('IP_Test_Max_Marks as i','i.subject_id','=','s.subject_id')
                  ->select('s.subject_id','s.subject_name','i.max_marks','i.pass_marks')
                  ->where('s.subject_name',$value->Field)
                  ->where('i.test_type_id',$test_type_id[0]->Test_type_id)
                  ->get();  

                  $a=$value->Field;

                    if(array_key_exists($a, $array))
                    {
                    $s[$a][1] = (object)array();
                    $s[$a][1]->obtained=$array[$a];

                    }

          }
          unset($s['sl'],$s['CAMPUS_ID'],$s['STUD_ID'],$s['exam_id']);
        return   [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                        'Details'=>$s,
                 ];
    }
}
