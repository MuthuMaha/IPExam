<?php

namespace App;
use File;
use DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Ipbipc extends Model
{
    protected $table='IP_BIPC_Marks';
    protected $primaryKey='sl';
    protected $fillable=['CAMPUS_ID','STUD_ID','exam_id','PHYSICS', 'CHEMISTRY', 'BIOLOGY', 'BOTANY', 'ZOOLOGY', 'ENGLISH', 'GK', 'TOTAL', 'SEC_RANK', 'CAMP_RANK', 'CITY_RANK', 'DISTRICT_RANK', 'STATE_RANK', 'ALL_INDIA_RANK', 'PHYSICS_RANK', 'CHEMISTRY_RANK', 'BIOLOGY_RANK', 'BOTANY_RANK', 'ZOOLOGY_RANK', 'ENGLISH_RANK', 'GK_RANK', 'M_RANK', 'P_RANK', 'C_RANK', 'MAT1', 'MAT2', 'MAT3', 'PHY1', 'PHY2', 'CHE1', 'CHE2', 'REG_RANK'];
    public $timestamps=false;

    public static function result_upload($data)
    {

    	
      $subject=DB::table('0_subjects')->where('subject_id',$data->SUBJECT_ID)->get();
        $marks=Ipexammarks::updateOrCreate(
          [
          'CAMPUS_ID'=>$data->CAMPUS_ID, 
          'STUD_ID'=>$data->STUD_ID,
          'exam_id'=>$data->EXAM_ID,
       	 ],[
          strtoupper($subject[0]->subject_name)=>$data->mark,
          // $subject[0]->subject_name=>$request->mark,
        ]
      )->get();
	$check=DB::table('IP_Exam_Conducted_For as a')
		->join('t_course_group as b', 'a.group_id', '=', 'b.GROUP_ID')
		->select('b.GROUP_NAME')
		->where('a.exam_id',$data->EXAM_ID)
		->get();
	// $subject=DB::table('0_subjects')->where('subject_name',Auth::user()->SUBJECT)->get();
	if(!count($subject)){
		  return [
                'Login' => [
                    'response_message'=>"login with Teacher Login ID",
                    'response_code'=>"0",
                    ],
            ];


	}
	$q=str_replace(".","",$check[0]->GROUP_NAME);
	// echo $q;
	if ($check[0]->GROUP_NAME='M.P.C')
	{
	  $path=public_path().'/Result_sheet/MPC/'.Auth::user()->CAMPUS_ID.'/'.$data->EXAM_ID.'/'.$data->STUD_ID.'/'.$subject[0]->subject_id;
	}
	if ($check[0]->GROUP_NAME='BI.P.C')
	{
		 $path=public_path().'/Result_sheet/BIPC/'.Auth::user()->CAMPUS_ID.'/'.$data->EXAM_ID.'/'.$data->STUD_ID.'/'.$subject[0]->subject_id;
	}	
	if($data->action==0){
		// Storage::deleteDirectory($path);
		array_map('unlink', glob($path."/*"));
		rmdir($path);
    	}     
	File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
	Ipexam::where('exam_id',$data->EXAM_ID)->update(['path'=>','.$path]);
	$images=array();
	if($files=$data->file('scan_files'))
	{
	    foreach($files as $file){
	        $name=rand().'.'.$file->getClientOriginalExtension();
	        $file->move($path,$name);
	        $images[]=$name;
	    }
	  }
	
	   return [
                'Login' => [
                    'response_message'=>"success",
                    'response_code'=>"1",
                    ],
                'Message'=>'Result uploaded successfully'
            ];

	   }
}
