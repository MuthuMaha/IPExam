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
   	 $exam_create=Ipexam::create([
                    'Exam_name'=>$data->Exam_Name,
                    'Date_exam'=>$data->Date_Exam,
                    'Test_type_id'=>$data->Test_Type_Id,
                    'Board'=>$data->Board,
                    'created_by'=>Auth::User()->USER_NAME,
                    'updated_by'=>"",
                ]);
        $type_create=Ipexamconductedfor::create([
 'exam_id'=>$exam_create->exam_id,
                    'group_id'=>$data->Group_Id,
                    'classyear_id'=>$data->Classyear_Id,
                    'stream_id'=>$data->Stream_Id,
                    'program_id'=>$data->Program_Id,

        ]);
     
      return ['success'=>['Message'=>'Created success']];
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
