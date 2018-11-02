<?php

namespace App;
use File;
use DB;
use Auth;
use App\Campusupload;
use App\BaseModels\Campus;
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
          $arr1=['PHYSICS','CHEMISTRY','MATHEMATICS','ENGLISH','GK'];
          $arr2=['PHYSICS','CHEMISTRY','BIOLOGY','BOTANY','ZOOLOGY','ENGLISH','GK'];
          // $arr2=['PHYSICS','CHEMISTRY','MATHEMATICS','BIOLOGY','BOTANY','ZOOLOGY','ENGLISH','GK'];
          $get="";
       $marklist=array();
        $list=array();
        $check_list=array();
        $count="";

      $subject=DB::table('0_subjects')->where('subject_id',$data->SUBJECT_ID)->get();
        $marks=Ipexammarks::updateOrCreate(
          [
          'CAMPUS_ID'=>$data->CAMPUS_ID, 
          'STUD_ID'=>$data->STUD_ID,
          'exam_id'=>$data->EXAM_ID,
       	 ],
         [
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
                    'response_code'=>"1",
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
	// if($data->action==0){
	// 	// Storage::deleteDirectory($path);
	// 	array_map('unlink', glob($path."/*"));
	// 	rmdir($path);
 //    	}     
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
                     $value=array();
                    $check_section=DB::table('IP_Exam_Conducted_For')
                              ->where('exam_id',$data->EXAM_ID)
                              ->get();
                              $exam_id=$data->EXAM_ID;
                    foreach ($check_section as $key => $value) {

                      $g=$value->group_id;
                      $c=$value->classyear_id;
                      $s=$value->stream_id;
                      $p=$value->program_id;
                    $section_list[$key]=Campus::
                    where('t_campus.CAMPUS_ID',$data->CAMPUS_ID)
                    // ->select('t_campus.CAMPUS_ID','b.SECTION_ID')
                    // ->with('city','state','district')
                   ->with(['section'=>function($q) use ($g,$c,$s,$p){

                    $q->where('c.GROUP_ID',$g);
                    $q->where('c.CLASS_ID',$c);
                    $q->where('c.STREAM_ID',$s);
                    $q->where('SECTION_NAME','!=','NOT_ALLOTTED');
                    // $q->distinct();
                    // $q->where('t_college_section.PROGRAM_ID',$p);  
                    }])
                   ->with(['check'=>function($q) use ($exam_id){
                    $q->where('exam_id',$exam_id);
                   }])
                    ->distinct()
                    ->get();

                    }
        // $check_section=DB::table('IP_Exam_Conducted_For')->where('exam_id',$data->EXAM_ID)->get();

        // foreach ($check_section as $key => $value) {

        //     $section_list[$key]=DB::table('t_course_track as a')
        //             ->join('t_college_section as b','a.COURSE_TRACK_ID','=','b.COURSE_TRACK_ID')
        //             // ->join('t_student as c','c.SECTION_ID','=','b.SECTION_ID')
        //             ->whereExists(function($query)
        //             {
        //                 $query->select(DB::raw(1))
        //                       ->from('t_student')
        //                       ->whereRaw('t_student.SECTION_ID = b.SECTION_ID');
        //             })
        //             ->where('a.GROUP_ID',$value->group_id)
        //             ->where('a.CLASS_ID',$value->classyear_id)
        //             ->where('a.STREAM_ID',$value->stream_id)
        //             // ->where('b.PROGRAM_ID',$value->program_id)   
        //             // ->where('b.CAMPUS_ID',$data->CAMPUS_ID)
        //             // ->where('c.ADM_NO',$data->STUD_ID)
        //             ->where('b.SECTION_NAME','!=','NOT_ALLOTTED')
        //             ->select('b.SECTION_ID','b.CAMPUS_ID')
        //             ->get();
        //             $count=+count($section_list[$key]);

        // }

        for ($j=0; $j <=count($section_list)-1 ; $j++) { 
            // for ($i=0; $i <=count($section_list[$j]) ; $i++) { 
                foreach ($section_list[$j] as $key => $value) {
                 
                $list=DB::table('t_student')
                        ->where('CAMPUS_ID',$value->CAMPUS_ID)
                        ->where('SECTION_ID',$value->section[0]->SECTION_ID)
                        ->select('ADM_NO')
                        ->get();
                }
            // }
        }

        foreach ($list as $key => $value) {
            $check_list[]=DB::table('IP_Exam_Marks')->where('STUD_ID',$value->ADM_NO)
            ->get();
        }
        $cc=count(array_filter($check_list));
        if(count($list)==$cc)
        {
            foreach ($list as $key => $value) 
            {
             
                if($check_section[0]->group_id=='4')
                {
                  
                   for ($i=0; $i <=count($arr2)-1 ; $i++) 
                   { 

                    $a=DB::table('IP_Exam_Marks')
                                ->where($arr2[$i],'0.00')
                                ->where('STUD_ID',$list[$key]->ADM_NO)
                                ->select('STUD_ID')
                                ->get();
                    if(isset($a[0]->STUD_ID))
                    $marklist[]=$a;
                    else
                    $marklist[]="";
                      
                   }
                }
                if($check_section[0]->group_id=='5')
                {
                    
                     for ($i=0; $i <=count($arr1)-1 ; $i++) 
                     { 

                    $a=DB::table('IP_Exam_Marks')
                                ->where($arr1[$i],'0.00')
                                ->wher('STUD_ID',$list[$key]->ADM_NO)
                                ->select('STUD_ID')                                
                                ->get();
                    if(isset($a[0]->STUD_ID))
                    $marklist[]=$a;
                    else
                    $marklist[]="";

                   }
                }

            }
        }
       // foreach ($marklist as $key => $value) {
       //  if (isset($value->STUD_ID)) {

       //     $get=$value->STUD_ID;
       //  }
       // }
        $mark=array_filter($marklist);
        if(count($mark)==0){

        for ($j=0; $j <=count($section_list)-1 ; $j++) { 
            // for ($i=0; $i <=count($section_list[$j]) ; $i++) { 
                foreach ($section_list[$j] as $key => $value) {
                 
            $insert=Campusupload::updateOrCreate([
                'CAMPUS_ID'=>$value->CAMPUS_ID,
                'exam_id'=>$data->EXAM_ID,
                'section_id'=>$value->SECTION_ID,
                'status'=>0,
            ]);

            }
        }
        }

	
	   return [
                'Login' => [
                    'response_message'=>"success",
                    'response_code'=>"1",
                    ],
                'Message'=>'Result uploaded successfully',
                // 'Section'=>$section_list,
                // 'list'=>$check_section,
                // 'count'=>$get,
                // 'list'=>$list,
                // 'checklist'=>$check_list,
                // 'marklist'=>array_filter($marklist),
                // 'mark'=>sizeof($mark),
                // 'group_id'=>$check_section[0]->group_id,
            ];

	   }
}
