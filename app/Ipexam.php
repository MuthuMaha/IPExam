<?php

namespace App;
use Auth;
use DB;
use App\BaseModels\Group;
use App\BaseModels\StudyClass as Classyear;
use App\BaseModels\Program as Tprogram;
use App\BaseModels\Stream;
use Illuminate\Database\Eloquent\Model;

class Ipexam extends Model
{
   protected $table='IP_Exam_Details';
   protected $primaryKey='exam_id';
   protected $fillable=['Exam_name', 'Date_exam', 'Test_type_id', 'Board', 'created_by', 'updated_by',];

   public static function ipcreate($data){
    if(Auth::id()){
    $user=Auth::id();
     }
     elseif(Auth::guard('t_student')->id()){
       $user=Auth::guard('t_student')->id();
     }
     elseif(Auth::guard('tparent')->id()){
      $user=Auth::guard('tparent')->id();
     }
     else{
      $user="";
     }
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
                    'created_by'=>$user,
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
   
     return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Message'=>'Exam Created Successfully',
                    ];
   }
   public static function ipupdate($data){
    
  $ip_data=DB::table('IP_Exam_Conducted_For as e')
            ->join('t_course_group as g', 'e.group_id', '=', 'g.GROUP_ID')
            ->join('t_study_class as c', 'e.classyear_id', '=', 'c.CLASS_ID')
            ->join('t_stream as s', 'e.stream_id', '=', 's.STREAM_ID')
            ->join('t_program_name as p', 'e.program_id', '=', 'p.PROGRAM_ID')
            ->where('e.exam_id',$data->id)
            ->select('g.GROUP_NAME','c.CLASS_NAME','s.STREAM_NAME','p.PROGRAM_NAME','e.sl')

            ->get();
            for($j=0;$j<=count($ip_data)-1;$j++){
            $ip_data[$j]->action=$data->url().'/'.$ip_data[$j]->sl;
          }
   return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Exam_Details'=>$ip_data,
                    ];

   }
   public static function ipeditexamdetails($data){
    $edit=Ipexamconductedfor::where('sl',$data->route('e_id'))
    ->update([
      'group_id'=>$data->Group_Id,
      'classyear_id'=>$data->Classyear_Id,
      'stream_id'=>$data->Stream_Id,
      'program_id'=>$data->Program_Id,
  ]);


   	 return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Message'=>'Updated Sucessfully',
                    ];
   }
   public static function deleteexamdetails($data){
     $deleteexamdetails=Ipexamconductedfor::where('sl',$data->route('e_id'))
     ->delete();
    return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Exam'=>'Deleted Sucessfully',
                    ];
   }
   public static function examdetailcreate($data){
     $examdetailcreate=Ipexamconductedfor::create([
      'exam_id'=>$data->route('id'),
      'program_id'=>$data->Program_Id,
      'stream_id'=>$data->Stream_Id,
      'group_id'=>$data->Group_Id,
      'classyear_id'=>$data->Classyear_Id,
     ]);
     return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Message'=>'Created Sucessfully',
                    ];
   }
   public static function editExam($data){
      if(Auth::id()){
    $user=Auth::id();
     }
     elseif(Auth::guard('t_student')->id()){
       $user=Auth::guard('t_student')->id();
     }
     elseif(Auth::guard('tparent')->id()){
      $user=Auth::guard('tparent')->id();
     }
     else{
      $user="";
     }
     $examdetailcreate=Ipexam::where('exam_id',$data->route('id'))
     ->update(['Exam_name'=>$data->Exam_name,'Date_exam'=>$data->Date_exam,'Test_type_id'=>$data->Test_Type_Id,'Board'=>$data->Board,'updated_by'=>$user]);
     return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Message'=>'Exam Updated Sucessfully',
                    ];
   }
}
