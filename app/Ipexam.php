<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Ipexam extends Model
{
   protected $table='IP_Exam_Details';
   protected $primaryKey='exam_id';
   protected $fillable=['Exam_name', 'Date_exam', 'Test_type_id', 'Board', 'created_by', 'updated_by',];

   public static function ipcreate($data){
     $a=array();
     $gi=explode(',',$data->Group_Id);
     $ci=explode(',',$data->Classyear_Id);
     $si=explode(',',$data->Stream_Id);
     $pi=explode(',',$data->Program_Id);
     $gi=array_filter($gi);
     $ci=array_filter($ci);
     $si=array_filter($si);
     $pi=array_filter($pi);
$a[0]=count($gi);
$a[1]=count($ci);
$a[2]=count($si);
$a[3]=count($pi);
$x=0;
for($i=0;$i<=count($a)-1;$i++){
  if($a[$i]>$x){
    $x=$a[$i];
  }
}
   	 $exam_create=Ipexam::create([
                    'Exam_name'=>$data->Exam_Name,
                    'Date_exam'=>$data->Date_Exam,
                    'Test_type_id'=>$data->Test_Type_Id,
                    'Board'=>$data->Board,
                    'created_by'=>Auth::User()->USER_NAME,
                    'updated_by'=>"",
                ]);
     for($j=0;$j<=$x-1;$j++){
      try {
        $type_create=Ipexamconductedfor::create([
     
 'exam_id'=>$exam_create->exam_id,
                    'group_id'=>$gi[$j],
                    'classyear_id'=>$ci[$j],
                    'stream_id'=>$si[$j],
                    'program_id'=>$pi[$j],

        ]);
      }
      catch(Exception $e){
        $type_create='Enter proper id';
      }
      }
   
      return 'success';
   }
   public static function ipupdate($data){
   	 $ip_update=Ipexam::where('exam_id',$data->exam_id)
        ->update([
                    'Exam_name'=>$data->Exam_Name,
                    'Date_exam'=>$data->Date_Exam,
                    'Test_type_id'=>$data->Test_Type_Id,
                    'Board'=>$data->Board,
                    'created_by'=>"",
                    'updated_by'=>Auth::User()->USER_NAME,
                ]);
        $ip_type=Ipexamconductedfor::where('exam_id',$data->exam_id)
        ->update([
                    'group_id'=>$data->Group_Id,
                    'classyear_id'=>$data->Classyear_Id,
                    'stream_id'=>$data->Stream_Id,
                    'program_id'=>$data->Program_Id,

        ]);
      return ['success'=>['Message'=>'Updated success']];

   }
}
