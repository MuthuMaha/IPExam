<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Campusupload extends Model
{
   protected $table='IP_Campus_Uploads';
   protected $primaryKey='CAMPUS_ID';
   protected $fillable=['CAMPUS_ID', 'exam_id', 'section_id', 'status'];
   public $timestamps=false;

   public static function result_store($data){
   	$check=DB::table('IP_Exam_Conducted_For as a')
	->join('t_course_group as b', 'a.group_id', '=', 'b.GROUP_ID')
	->select('b.GROUP_NAME')
	->where('a.exam_id',$data->EXAM_ID)
	->get();
   	Campusupload::updateOrCreate(['CAMPUS_ID'=>$data->CAMPUS_ID,'exam_id'=>$data->EXAM_ID,],['section_id'=>$data->section_id,'status'=>$data->status,]);
	$arr=['PHYSICS'=>$data->PHYSICS, 'CHEMISTRY'=>$data->CHEMISTRY,'ENGLISH'=>$data->ENGLISH, 'GK'=>$data->GK, 'TOTAL'=>$data->TOTAL, 'SEC_RANK'=>$data->SEC_RANK, 'CAMP_RANK'=>$data->CAMP_RANK, 'CITY_RANK'=>$data->CITY_RANK, 'DISTRICT_RANK'=>$data->DISTRICT_RANK, 'STATE_RANK'=>$data->STATE_RANK, 'ALL_INDIA_RANK'=>$data->ALL_INDIA_RANK, 'PHYSICS_RANK'=>$data->PHYSICS_RANK, 'CHEMISTRY_RANK'=>$data->CHEMISTRY_RANK, 'ENGLISH_RANK'=>$data->ENGLISH_RANK, 'GK_RANK'=>$data->GK_RANK, 'M_RANK'=>$data->M_RANK, 'P_RANK'=>$data->P_RANK, 'C_RANK'=>$data->C_RANK, 'MAT1'=>$data->MAT1, 'MAT2'=>$data->MAT1, 'MAT3'=>$data->MAT3, 'PHY1'=>$data->PHY1, 'PHY2'=>$data->PHY2, 'CHE1'=>$data->CHE1, 'CHE2'=>$data->CHE2, 'REG_RANK'=>$data->REG_RANK];

		if($check[0]->GROUP_NAME=='BI.P.C')
		{
		$arr['BIOLOGY']=$data->BIOLOGY; 
		$arr['BOTANY']=$data->BOTANY;
		$arr['ZOOLOGY']=$data->ZOOLOGY;
		$arr['BIOLOGY_RANK']=$data->BIOLOGY_RANK;
		$arr['BOTANY_RANK']=$data->BOTANY_RANK;
		 $arr['ZOOLOGY_RANK']=$data->ZOOLOGY_RANK;
		  Ipbpc::updateOrCreate(['CAMPUS_ID' => $data->CAMPUS_ID, 'STUD_ID' => $data->STUD_ID,'exam_id' => $data->EXAM_ID,],$arr);
		}

		if($check[0]->GROUP_NAME=='M.P.C')
		{
		$arr['MATHEMATICS']=$data->MATHEMATICS;
		$arr['CAMPUS']=$data->CAMPUS;
		$arr['MATHEMATICS_RANK']=$data->MATHEMATICS_RANK;
		unset($arr['ENGLISH_RANK'],$arr['GK_RANK']);
		Ipmpc::updateOrCreate(['CAMPUS_ID' => $data->CAMPUS_ID, 'STUD_ID' => $data->STUD_ID,'exam_id' => $data->EXAM_ID,],$arr);
		     
		}
    

   		return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                            'Message'=>'Result uploaded successfully',
                    ];


   }
   public static function result_delete($data){
   	 $check=DB::table('IP_Exam_Conducted_For as a')
	->join('t_course_group as b', 'a.group_id', '=', 'b.GROUP_ID')
	->select('b.GROUP_NAME')
	->where('a.exam_id',$data->EXAM_ID)
	->get();
   	$result_delete=Campusupload::where(['CAMPUS_ID' => $data->CAMPUS_ID,'exam_id' => $data->EXAM_ID,])->delete();
   		if($check[0]->GROUP_NAME=='BI.P.C')
		{
		  Ipbpc::where(['CAMPUS_ID' => $data->CAMPUS_ID, 'STUD_ID' => $data->STUD_ID,'exam_id' => $data->EXAM_ID,])->delete();
		}

		if($check[0]->GROUP_NAME=='M.P.C')
		{
		Ipmpc::where(['CAMPUS_ID' => $data->CAMPUS_ID, 'STUD_ID' => $data->STUD_ID,'exam_id' => $data->EXAM_ID,])->delete();
		     
		}
    
   
   		return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                            'Message'=>'Result deleted successfully',
                    ];

   }
   public static function ip_delete($id){

      $d=Campusupload::where('exam_id',$id)->get();
      if(count($d)==0){
        $ip_delete=Ipexam::where('exam_id',$id)
        ->delete();
        $ip_examcon=Ipexamconductedfor::where('exam_id',$id)->delete();
        return ['success'=>['Message'=>'Deleted success']];
      }
      return ['success'=>['Message'=>'Not Deleted because of some result upload']];

   }
}
