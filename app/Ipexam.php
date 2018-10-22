<?php

namespace App;
use Auth;
use DB;
use App\BaseModels\Group;
use App\Ipexamconductedfor;
use App\BaseModels\StudyClass as Classyear;
use App\BaseModels\Program as Tprogram;
use App\BaseModels\Stream;
use Illuminate\Database\Eloquent\Model;

class Ipexam extends Model
{
   protected $table='IP_Exam_Details';
   protected $primaryKey='exam_id';
   protected $fillable=['Exam_name', 'Date_exam','End_Date','last_date_to_upload', 'Test_type_id', 'Board','SCHEDULED_PROGRAM_ID', 'created_by', 'updated_by'];

 public function conduct() {
        return $this->hasMany(Ipexamconductedfor::class, 'exam_id', 'exam_id');
    }
     

   public static function ipcreate($data){
    // if(Auth::id()){
    // $user=Auth::id();
    //  }
    //  elseif(Auth::guard('t_student')->id()){
    //    $user=Auth::guard('t_student')->id();
    //  }
    //  elseif(Auth::guard('tparent')->id()){
    //   $user=Auth::guard('tparent')->id();
    //  }
    //  else{
    //   $user="";
    //  }
     $a=array();
     $gi=explode(',',$data->Group_Id);
     $ci1=implode(',',$data->Classyear_Id);
     $ci=explode(',',$ci1);
     $si1=implode(',', $data->Stream_Id);
     $si=explode(',',$si1);
     $pi1=implode(',',$data->Program_Id);
     $pi=explode(',',$pi1);
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
      if($data->update=='0'){
     $exam_create=Ipexam::create([
                    'Exam_name'=>$data->Exam_name,
                    'Date_exam'=>$data->Date_exam,
                    'End_Date'=>$data->End_Date,
                    'last_date_to_upload'=>$data->last_date_to_upload,
                    'Test_type_id'=>$data->Test_type_id,
                    'Board'=>$data->Board,
                    'SCHEDULED_PROGRAM_ID'=>$data->SCHEDULED_PROGRAM_ID,
                    'created_by'=>$data->User,
                    'updated_by'=>"",
                ]);
     for($j=0;$j<=$x-1;$j++){
      try {
        $type_create=Ipexamconductedfor::create([
     
                    'exam_id'=>$exam_create->exam_id,
                    'group_id'=>$gi[0],
                    'classyear_id'=>$ci[$j],
                    'stream_id'=>$si[$j],
                    'program_id'=>$pi[$j],

        ]);
      }
      catch(Exception $e){
        $type_create='Enter proper id';
      }
      }
   }
   elseif($data->update=='1'){

     for($j=0;$j<=$x-1;$j++){
      try {
        $type_create=Ipexamconductedfor::create([
     
                    'exam_id'=>$data->exam_id,
                    'group_id'=>$gi[0],
                    'classyear_id'=>$ci[$j],
                    'stream_id'=>$si[$j],
                    'program_id'=>$pi[$j],

        ]);
      }
      catch(Exception $e){
        $type_create='Enter proper id';
      }
      }
   }
   else{}
     return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Message'=>'Exam Created Successfully',
                    ];
   
   
   }
   public static function createIPExamname($data){
    // if(Auth::id()){
    // $user=Auth::id();
    //  }
    //  elseif(Auth::guard('t_student')->id()){
    //    $user=Auth::guard('t_student')->id();
    //  }
    //  elseif(Auth::guard('tparent')->id()){
    //   $user=Auth::guard('tparent')->id();
    //  }
    //  else{
    //   $user="";
    //  }
    $test=Ipexam::where('SCHEDULED_PROGRAM_ID',$data->SCHEDULED_PROGRAM_ID)->get();
    $type_create=array();
    $value=array();
     $a=array();
     $gi=explode(',',$data->group_id);
    
     $ci1=implode(',', $data->class_id);
     $stream1=implode(',', $data->stream);
     $ci=explode(',',$ci1);
     $si=explode(',',$stream1);
   // print_r($data->program_id);exit;
      $prog1=implode(',', $data->program_id);
     $pi=explode(',',$prog1);
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
   	 // $exam_create=Ipexam::create([
     //                'Exam_name'=>$data->Exam_name,
     //                'Date_exam'=>$data->Date_exam,
     //                'End_Date'=>$data->End_Date,
     //                'last_date_to_upload'=>$data->last_date_to_upload,
     //                'Test_type_id'=>$data->Test_type_id,
     //                'Board'=>$data->Board,
     //                'created_by'=>$data->User,
     //                'updated_by'=>"",
     //            ]);
      // print_r($x);exit;
      if($x>4){
        return "";
      }
     for($j=0;$j<=$x-1;$j++){
      try {
        $type_create[]=Ipexamconductedfor::
                    join('t_program_name as b','b.PROGRAM_ID','IP_Exam_Conducted_For.program_id')
                    ->where([
                    'IP_Exam_Conducted_For.group_id'=>$gi[0],
                    'IP_Exam_Conducted_For.classyear_id'=>$ci[$j],
                    'IP_Exam_Conducted_For.stream_id'=>$si[$j],
                    'b.program_name'=>$pi[$j],

        ]);
         $value[]=DB::select("select cg.GROUP_NAME,sc.DISPLAY_NAME,s.STREAM_NAME,ty.test_type_name,tm.test_mode_name from t_course_group cg,t_study_class sc,t_stream s,0_test_modes tm,0_test_types ty where cg.GROUP_ID='{$gi[0]}' and sc.CLASS_ID='{$ci[$j]}' and s.STREAM_ID='{$si[$j]}' and ty.test_type_id='{$data->test_type}'");
      }
      catch(Exception $e){
        $type_create='Enter proper id';
      }
      }
   $program_name=$data->program_name;
    $group_name=$value[0][0]->GROUP_NAME;
    $class_name=$value[0][0]->DISPLAY_NAME;
    $stream_name=$value[0][0]->STREAM_NAME;
    $test_type_name=$value[0][0]->test_type_name;
    // $test_mode_name=$value[0]['test_mode_name'];

    //class
    $first=$class_name[0].$class_name[1];

    //group  
    
           if($group_name=="M.P.C")
           {
              $second="MPC";  
           }
           else if($group_name == "BI.P.C")
           {
              $second="BIPC";
           }
           else if($group_name == "M.BI.P.C")
           {
              $second="MBIPC";
           }
           else 
           {
             $second=substr($group_name, 0,3);
           }
           
      
      //stream 
    if($stream_name=="ICON")
      {
        $third="ICON";
      }
    else
    {
      $third=substr($stream_name, 0, 3);
    }

    //test type
    if($test_type_name=="WEEK-END")
    {
      $fifth="WEEK-END";
    }
    else if($test_type_name=="UNIT-TEST")
    {
        $fifth="UNIT-TEST"; 
    }
    else if($test_type_name=="GRAND TEST")
    {
        $fifth="GRAND TEST";  
    }
    else if($test_type_name=="CUMULATIVE")
    {
        $fifth="CUMULATIVE";  
    }
    else if($test_type_name=="PART-TEST")
    {
        $fifth="PART-TEST"; 
    }
    else{
       $fifth=substr($test_type_name, 0, 2);
    }


    //$test_code=$first . "-" . $second . "-" . $third . "-" . $fourth . "-" . $fifth;


//need to change here

    if($program_name=="PH1" || $program_name=="PH2" || $program_name=="PH3")
    {
      
       $test_code=$first."_".$third."_".$second."_".$fifth."_".$program_name.'_'.$start_date.'_'.$last_date_to_upload;

    }
    else
    {
      $pro=explode("_", $program_name);
      
      //$stream1=$pro[1];
      if(count($pro)){
      if($pro[1]=="ICON")
      {
        $pro[1]="IIT";
        $str=implode("_",$pro);
        $program=$str;

      }
      else
      {
        $program=$program_name;
      }
      }
      $test_code = $program.'_'.$fifth;
    }

    
$cnt=count($type_create);
$cnt1=count($test);

  $date = new \DateTime($_POST['start_date']);
$st=$date->format('j-F-Y');

  $date = new \DateTime($_POST['last_date_to_upload']);
$ldtu=$date->format('j-F-Y');
// if($cnt==$cnt1)
//  $test_code= $program_name.'_'.$second.'_'.$fifth.$cnt.'_'.$st.'_'.$ldtu;
// else
$cnt1=$cnt1+1;
 $test_code= $program_name.'_'.$second.'_'.$fifth.$cnt1.'_'.$st.'_'.$ldtu;

     return $test_code;
   }
   public static function ipupdate($data){
    
  $ip_data=DB::table('IP_Exam_Conducted_For as e')
            ->join('IP_Exam_Details as a','e.exam_id','=','a.exam_id')
            ->join('t_course_group as g', 'e.group_id', '=', 'g.GROUP_ID')
            ->join('t_study_class as c', 'e.classyear_id', '=', 'c.CLASS_ID')
            ->join('t_stream as s', 'e.stream_id', '=', 's.STREAM_ID')
            ->join('t_program_name as p', 'e.program_id', '=', 'p.PROGRAM_ID')
            ->where('e.exam_id',$data->id)
            ->select('g.GROUP_NAME','c.CLASS_NAME','s.STREAM_NAME','p.PROGRAM_NAME','e.sl','a.Exam_name')

            ->get();
            for($j=0;$j<=count($ip_data)-1;$j++){
            $ip_data[$j]->action=$data->url().'/'.$ip_data[$j]->sl;
          }
   return $ip_data;

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
      //   if(Auth::id()){
      // $user=Auth::id();
      //  }
      //  elseif(Auth::guard('t_student')->id()){
      //    $user=Auth::guard('t_student')->id();
      //  }
      //  elseif(Auth::guard('tparent')->id()){
      //   $user=Auth::guard('tparent')->id();
      //  }
      //  else{
      //   $user="";
      //  }
       $examdetailcreate=Ipexam::where('exam_id',$data->id)
       ->update([$data->name=>$data->value]);
     return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Message'=>'Exam Updated Sucessfully',
                    ];
   }
}
