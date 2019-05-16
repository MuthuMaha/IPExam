<?php

namespace App;
use App\BaseModels\Campus;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\CampusCollection;
// use App\Http\Resources\Campus;

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
   public static function campsection($data){
    $cond=DB::table('IP_Exam_Conducted_For')
                              ->whereRaw('exam_id = ?',$data->exam_id)
                              ->get();

            $a=array();
            $b=array();
   
             foreach ($cond as $key => $value) {

                $b[]='(c.GROUP_ID="'.$value->group_id.'" and c.CLASS_ID="'.$value->classyear_id.'" and c.STREAM_ID="'.$value->stream_id.'" and t_college_section.PROGRAM_ID="'.$value->program_id.'")';


                      }
    $camcount=static::total($b,$data->exam_id)['count'];
    $camcheck=static::total($b,$data->exam_id)['check1'];
                       $examlist=new CampusCollection(Campus::
                    // with('city','state','district')
                   with(['section'=>function($q) use ($b){ 
                    if(count($b)!=0){
                     foreach ($b as $key => $value) 
                     {
                        $q->orwhereRaw($value);                  
                      }  
                    }
                    }

                  ])
                  
                   ->whereIn('t_campus.CAMPUS_ID',$camcount)
                    ->distinct()
                    ->get()); 
                    return $examlist;
   }
   public static function skipsection($data){
     $cond=DB::table('IP_Exam_Conducted_For')
                              ->whereRaw('exam_id = ?',$data->exam_id)
                              ->get();

            $a=array();
            $b=array();
             foreach ($cond as $key => $value) {

                $b[]='(c.GROUP_ID="'.$value->group_id.'" and c.CLASS_ID="'.$value->classyear_id.'" and c.STREAM_ID="'.$value->stream_id.'" and t_college_section.PROGRAM_ID="'.$value->program_id.'")';


                      }

    $section=DB::table('t_college_section')
                  ->join('t_course_track as c','c.COURSE_TRACK_ID','t_college_section.COURSE_TRACK_ID')
                    // ->join('t_student as st','st.SECTION_ID','t_college_section.SECTION_ID')
                  ->whereExists(function($query)
                        {
                            $query->select(DB::raw(1))
                                  ->from('t_student')
                                  ->where('t_student.SECTION_ID','=','t_college_section.SECTION_ID')
                                   ->where('t_college_section.section_name','<>','NOT_ALLOTTED')
                                   ->where('t_college_section.section_name','<>','');
                        })
                  ->orderby('t_college_section.SECTION_ID','ASC')
                  ->select('t_college_section.SECTION_ID','t_college_section.section_name')
                  ->orwhere(function($q) use ($b) {
                    for($i=0;$i<=(count($b)-1);$i++) {
                      $q->orwhereRaw($b[$i]);
                        }  
                   })
                  ->get();
               
                    
                    return $section;

   }
   public static function sectionlist($data){
    $examlist[0]=array();
     $cond=DB::table('IP_Exam_Conducted_For')
                              ->where('exam_id',$data->exam_id)
                              ->get();
            $a=array();
            $b=array();
             foreach ($cond as $key => $value) {

                $b[]='(c.GROUP_ID="'.$value->group_id.'" and c.CLASS_ID="'.$value->classyear_id.'" and c.STREAM_ID="'.$value->stream_id.'" and t_college_section.PROGRAM_ID="'.$value->program_id.'")';


                      }
    $camcount=static::total($b,$data->exam_id)['count'];
    $camcheck=static::total($b,$data->exam_id)['check1'];
                    $value=array();
                   
                              $exam_id=$data->exam_id;
      if($data->campus_id==0 && count($cond)!=0)
     {  
                    $examlist[0]=Campus::
                    with('city','state','district')
                   ->with(['section'=>function($q) use ($b){ 
                    if(count($b)!=0){
                     foreach ($b as $key => $value) 
                     {
                        $q->orwhereRaw($value);                  
                      }  
                    }
                    }

                  ])
                   ->with(['check'=>function($q) use ($exam_id){
                    $q->where('exam_id',$exam_id);
                   }])
                   ->whereIn('t_campus.CAMPUS_ID',$camcount)
                    ->distinct()
                    ->paginate(10);   

                    
                }
                if ($data->status=='1') {

                    $examlist[0]=Campus::
                    with('city','state','district')
                   ->with(['section'=>function($q) use ($b){ 
                    if(count($b)!=0){
                     foreach ($b as $key => $value) 
                     {
                        $q->orwhereRaw($value);                  
                      }  
                    }
                    }

                  ])
                   ->with(['check'=>function($q) use ($exam_id){
                    $q->where('exam_id',$exam_id);
                   }])
                   ->whereIn('t_campus.CAMPUS_ID',$camcount)
                   ->whereIn('t_campus.CAMPUS_ID',$camcheck)
                    ->distinct()
                    ->paginate(10);   


                }
                if ($data->status=='2') {

                    $examlist[0]=Campus::
                    with('city','state','district')
                   ->with(['section'=>function($q) use ($b){ 
                    if(count($b)!=0){
                     foreach ($b as $key => $value) 
                     {
                        $q->orwhereRaw($value);                  
                      }  
                    }
                    }

                  ])
                   ->with(['check'=>function($q) use ($exam_id){
                    $q->where('exam_id',$exam_id);
                   }])
                   ->whereIn('t_campus.CAMPUS_ID',$camcount)
                   ->whereNotIn('t_campus.CAMPUS_ID',$camcheck)
                    ->distinct()
                    ->paginate(10);   


                }

      if($data->campus_id!=0 && count($cond)!=0)
      {

                       $examlist[0]=Campus::
                    with('city','state','district')
                     ->with(['section'=>function($q) use ($a,$b){                    
                    
                    foreach ($a as $key => $value) 
                    {                     
                     if($key==0)
                      {
                      $q->whereRaw($a[$key]); 
                      }
                    }
                    if(count($b)!=0){
                     foreach ($b as $key => $value) 
                     {
                        $q->orwhereRaw($value);                  
                      }  
                    }
                    }

                  ])
                   ->with(['check'=>function($q) use ($exam_id){
                    $q->whereRaw('exam_id = ?',$exam_id);
                   }])
                   ->where('CAMPUS_ID',$data->campus_id)
                    ->distinct()
                    ->paginate(20);                    

      }

        $object = new \stdClass(); 
        $object->exam_id = $data->exam_id;

       return [

        'exam'=>$examlist,
        'campus'=>static::total($b,$data->exam_id)['count1'],
        'upcampus'=>count(static::uploadstatus($object)['Campus']),
        'total'=>static::total($b,$data->exam_id)['count'],
        // 'check1'=>static::total($b,$data->exam_id)['check1'],

      ];
   }
   public static function uploadstatus($data){

      $campus=Campusupload::select('CAMPUS_ID')->whereRaw('exam_id = ?',$data->exam_id)->distinct()->get();
      $section=Campusupload::select('section_id')->whereRaw('exam_id = ?',$data->exam_id)->distinct()->get();
      return [
              'Campus'=>$campus,
              'Section'=>$section,
              ];

   }
   public static function total($b,$exam_id){
    $count=array();
    $count1=array();
    $check1=array();
    $cal=array();
    $examlist[0]=array();

                    $examlist[0]=Campus::
                    with('city','state','district')
                   ->with(['section'=>function($q) use ($b){    
                   // $q->where('t_college_section.SECTION_ID', '=', DB::table('t_student')->get('SECTION_ID'));
                    if(count($b)!=0){
                     foreach ($b as $key => $value) 
                     {
                        $q->orwhereRaw($value);                  
                      }  
                    }
                    }

                  ])
                   ->with(['check'=>function($q) use ($exam_id){
                    $q->whereRaw('exam_id = ?',$exam_id);
                   }])
                   // ->where('section','<>','')
                    ->distinct()
                    ->get();
        // $count1 = new \stdClass(); 
                    
                // }
    foreach ($examlist as $key => $value) {
      foreach ($value as $key => $value1) {
        if(isset($value1->section[0])){
          $count[]=$value1->CAMPUS_ID;
          // $count1->CAMPUS_ID=$value1->CAMPUS_ID;
          $count1[]=$value1->CAMPUS_NAME;
          $cal[]=count($value1->section);
        }
        if(count($value1->section)&& count($value1->check)){
          $check1[]=$value1->CAMPUS_ID;
        }
      }
    }
    return [
          'count'=>$count,
          'count1'=>$count1,
          'check1'=>$check1,
          'cal'=>$cal,
            ];

   }
}
