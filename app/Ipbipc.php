<?php

namespace App;
use File;
use DB;
use Illuminate\Database\Eloquent\Model;

class Ipbipc extends Model
{
    protected $table='IP_BIPC_Marks';
    protected $primaryKey='sl';
    protected $fillable=['CAMPUS_ID','STUD_ID','exam_id','PHYSICS', 'CHEMISTRY', 'BIOLOGY', 'BOTANY', 'ZOOLOGY', 'ENGLISH', 'GK', 'TOTAL', 'SEC_RANK', 'CAMP_RANK', 'CITY_RANK', 'DISTRICT_RANK', 'STATE_RANK', 'ALL_INDIA_RANK', 'PHYSICS_RANK', 'CHEMISTRY_RANK', 'BIOLOGY_RANK', 'BOTANY_RANK', 'ZOOLOGY_RANK', 'ENGLISH_RANK', 'GK_RANK', 'M_RANK', 'P_RANK', 'C_RANK', 'MAT1', 'MAT2', 'MAT3', 'PHY1', 'PHY2', 'CHE1', 'CHE2', 'REG_RANK'];
    public $timestamps=false;

    public static function result_upload($data)
    {
	$check=DB::table('IP_Exam_Conducted_For as a')
		->join('t_course_group as b', 'a.group_id', '=', 'b.GROUP_ID')
		->select('b.GROUP_NAME')
		->where('a.exam_id',$data->EXAM_ID)
		->get();
	if ($check[0]->GROUP_NAME='M.P.C')
	{
	  $path=public_path().'/Result_sheet/MPC/'.$data->CAMPUS_ID.'/'.$data->EXAM_ID.'/'.$data->STUD_ID.'/'.$data->SUBJECT_ID;
	}
	if ($check[0]->GROUP_NAME='BI.P.C')
	{
		 $path=public_path().'/Result_sheet/BIPC/'.$data->CAMPUS_ID.'/'.$data->EXAM_ID.'/'.$data->STUD_ID.'/'.$data->SUBJECT_ID;
	}	     
	File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
	Ipexam::where('exam_id',$data->EXAM_ID)->update(['path'=>','.$path]);
	$images=array();
	if($files=$data->file('files'))
	{
	    foreach($files as $file){
	        $name=rand().'.'.$file->getClientOriginalExtension();
	        $file->move($path,$name);
	        $images[]=$name;
	    }
	  }
	     return ['success'=>['Message'=>'Result uploaded successfully']];

	   }
}
