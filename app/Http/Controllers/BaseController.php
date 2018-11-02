<?php
namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\BaseModels\Group as groups;
use App\BaseModels\StudyClass as class_year;
use App\Http\Resources\Group as GroupResource;
use App\BaseModels\CourseTrack as course_track;
use App\BaseModels\Stream;
use App\BaseModels\Program;
use App\BaseModels\Section;
use DB;
use App\Ipexammarks;
use Auth;
use App\Ipmpc;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\StudyClassCollection;
use App\Http\Resources\StreamCollection;
use App\Http\Resources\ProgramCollection;
use App\Http\Resources\SectionCollection;


class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function groups()
    {
        //
        $data=new GroupCollection(groups::distinct('GROUP_ID')->orderBy('GROUP_ID')->get());
        $subject=DB::table('IP_Exam_Section as a')
                  ->join('0_subjects as b','a.subject_id','=','b.SUBJECT_ID')
                  ->where('a.EMPLOYEE_ID',Auth::user()->PAYROLL_ID)
                  ->select('b.subject_id','b.subject_name')
                  ->distinct()
                  ->get();
        return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Data'=>$data,
                        'Subject'=>$subject,
                    ];

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function class_year_wrt_group(Request $request, $id)
    {
        //
    
       $data= new StudyClassCollection(class_year::whereIn('CLASS_ID',course_track::where('GROUP_ID',$id)->pluck('CLASS_ID'))->get());
        return [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                    'Data'=>$data,
                ];
                
    
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function stream_wrt_group_class_year(Request $request)
    { 
        
        //Get group and class year to filter required streams
        $group_id= $request->group_id;
        $class_id= $request->class_id;
        
        // $fields = [
            
        //     'group_id' => $group_id,
        //     'class_id' => $class_id,
        // ];  
        // /* Validate group and class_id*/
        // $validator = Validator::make($fields, [
        //      'group_id' => 'required',
        //      'class_id' => 'required'
        // ]);

        // if ($validator->fails()){

        //     return [
        //         'message' => 'validation_failed',
        //         'errors' => $validator->errors()
        //     ];
        
        // }

        $data=new StreamCollection(Stream::whereIn('STREAM_ID',course_track::distinct('STREAM_ID')
                            ->where('STREAM', '<>','NULL')
                            ->where('GROUP_ID',$group_id)
                            ->where('CLASS_ID',$class_id)->get())->get());
        return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Data'=>$data,
                    ];
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function programs_wrt_stream_class_year(Request $request)
    {
        //
        $stream_id= $request->stream_id;
        $class_id= $request->class_id;
       $data=new ProgramCollection(Program::where('STREAM_ID', '=',$stream_id)
            ->where('CLASS_ID',$class_id)->get());
        return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Data'=>$data,
                    ];

    }

    public function sections_programs_wrt_stream_class_year(Request $request)
    {
        $stream_id= $request->stream_id;
        $class_id= $request->class_id;
        $program_id= $request->program_id;
        //
         $data1=DB::table('t_student as a')
                ->join('t_course_group as b','a.GROUP_NAME','=','b.GROUP_NAME')
                ->where('a.STREAM_ID',$stream_id)
                ->where('a.CLASS_ID',$class_id)
                ->where('a.PROGRAM_ID',$program_id)
                ->where('a.CAMPUS_ID',Auth::user()->CAMPUS_ID)
                ->distinct('a.SECTION_ID')
                ->select('a.SECTION_ID')
                // ->limit(1000)
                // ->count('a.SECTION_ID');
                ->get();

       $data=new SectionCollection(Section::
            join('IP_Exam_Section as b','t_college_section.SECTION_ID','=','b.SECTION_ID')
            ->where('t_college_section.PROGRAM_ID', '=',$program_id)
            ->where('t_college_section.CAMPUS_ID', '=',Auth::user()->CAMPUS_ID)
            // ->where('t_college_section.section_name','<>','NOT_ALLOTTED')
            // ->where('t_college_section.section_name','<>','')
            // ->where('t_college_section.section_name','<>','NILL')
            // ->where('t_college_section.section_name','<>','0')
            // ->where('CLASS_ID',$class_id)
            ->get());
        return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Data'=>$data,
                    ];

    }

    public function student_upload(Request $request)
    {        
      $sub_name=DB::table('0_subjects')
                    ->where('subject_id',$request->subject_id)
                    ->get();

        $stream_id= $request->stream_id;
        $class_id= $request->class_id;
        $program_id= $request->program_id;
        $group_id= $request->group_id;
        $section_id= $request->section_id;
       $data=DB::table('t_student as a')
                ->join('t_course_group as b','a.GROUP_NAME','=','b.GROUP_NAME')
                ->where('b.GROUP_ID',$group_id)
                ->where('a.STREAM_ID',$stream_id)
                ->where('a.CLASS_ID',$class_id)
                ->where('a.SECTION_ID',$section_id)
                ->where('a.PROGRAM_ID',$program_id)
                // ->where('a.CAMPUS_ID',Auth::user()->CAMPUS_ID)
                ->select('a.ADM_NO','a.NAME','a.GROUP_NAME')
                ->get();

        $subject=DB::table('t_employee as a')
                    ->join('0_subjects as b','b.subject_name','=','a.SUBJECT')
                    ->where('a.PAYROLL_ID',Auth::user()->PAYROLL_ID)
                    ->where('a.SUBJECT','LIKE','%'.Auth::user()->SUBJECT)
                    ->select('subject_id')
                    ->get();

                 foreach ($data as $key => $value) 
                 {
                  
                  $ip_exam=DB::table('IP_Exam_Marks')
                                ->where('STUD_ID',$value->ADM_NO)
                                ->where('exam_id',$request->EXAM_ID)
                                ->select(strtoupper($sub_name[0]->subject_name))
                                ->get();

          $object = new \stdClass(); 
          $object->EXAM_ID = $request->EXAM_ID;
          $object->test_type_id = $request->test_type_id;
          $object->STUD_ID = $value->ADM_NO;
          $data[$key]->{'Percentages'}= Ipmpc::markDetails($object)["OverAll_Averages"];
          $data[$key]->{'Total'}=Ipmpc::markDetails($object)["Add"];
 
                    if ($value->GROUP_NAME='M.P.C')
                    {
                      $path=public_path().'/Result_sheet/MPC/'.Auth::user()->CAMPUS_ID.'/'.$request->EXAM_ID.'/'.$value->ADM_NO.'/'.$request->subject_id;
                    }
                    if ($value->GROUP_NAME='BI.P.C')
                    {
                      $path=public_path().'/Result_sheet/BIPC/'.Auth::user()->CAMPUS_ID.'/'.$request->EXAM_ID.'/'.$value->ADM_NO.'/'.$request->subject_id;
                    }
                    // $subjects[$key]->{$value->subject_name}=scandir($path."/");  
                    if(str_replace("/var/www/html/","http://175.101.3.68/",glob($path."/*.{jpg,gif,png,bmp}",GLOB_BRACE)))
                    $data[$key]->{'status'}='1'; 
                    else 
                    $data[$key]->{'status'}='0';

                  if(count($ip_exam))
                     $data[$key]->{'mark'}=$ip_exam[0]->{strtoupper($sub_name[0]->subject_name)}; 
                   else
                    $data[$key]->{'mark'}="0";
                }
        return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Data'=>$data,
                        // 'Marks'=>$object,

                    ];

    }
     public function student_upload_marks(Request $request)
    {
      $subject=DB::table('0_subjects')->where('subject_id',$request->SUBJECT_ID)->get();
        $marks=Ipexammarks::updateOrCreate(
          [
          'CAMPUS_ID'=>$request->CAMPUS_ID, 
          'STUD_ID'=>$request->STUD_ID,
          'exam_id'=>$request->EXAM_ID,
        ],[
          strtoupper($subject[0]->subject_name)=>$request->mark,
          // $subject[0]->subject_name=>$request->mark,
        ]
      )->get();
        return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                        'Message'=>'Mark created/updated successfully',
                    ];

    }
    public function exam_upload_details(Request $request){
      $data1="";
       $query['Test']=array();
         // $test_types=DB::table('0_test_types')->where('test_type_id',$request->test_type_id)->get();
     //    foreach($test_types as $value){
      $section=$this->sections_programs_wrt_stream_class_year($request)["Data"];
      if(!count($section)){
           return [
                        'Login' => [
                            'response_message'=>"No record found check your login ID",
                            'response_code'=>"1",
                            ],
                            'Details'=>$query,
                    ];
      }
      $a=0;
      $d=0;
      $chek=0;
      $hold=0;
        $subject=DB::table('t_employee as a')
                    ->join('0_subjects as b','b.subject_name','=','a.SUBJECT')
                    ->where('a.PAYROLL_ID',Auth::user()->PAYROLL_ID)
                    ->where('a.SUBJECT','LIKE','%'.Auth::user()->SUBJECT)
                    ->select('subject_id')
                    ->get();
        $stream_id= $request->stream_id;
        $class_id= $request->class_id;
        $program_id= $request->program_id;
        $group_id= $request->group_id;
        // $section_id= $request->section_id;
        for ($i=0; $i <=count($section) ; $i++) { 
         if(isset($section[$i]->section_name))
       $data1=DB::table('t_student as a')
                ->join('t_course_group as b','a.GROUP_NAME','=','b.GROUP_NAME')
                ->join('t_college_section as c','c.section_id','a.SECTION_ID')
                ->where('b.GROUP_ID',$group_id)
                ->where('a.STREAM_ID',$stream_id)
                ->where('a.CLASS_ID',$class_id)
                ->where('c.section_name',$section[$i]->section_name)
                ->where('a.PROGRAM_ID',$program_id)
                ->where('a.CAMPUS_ID',Auth::user()->CAMPUS_ID)
                ->select('a.ADM_NO','a.NAME','a.GROUP_NAME')
                ->get();
                $hold+=count($data1);
                if(!count($data1)){
           return [
                        'Login' => [
                            'response_message'=>"No record found check your login ID",
                            'response_code'=>"1",
                            ],
                            'Details'=>$query,
                    ];
      }
                // $chek+=count($data1);
        }
             $data=DB::table('t_student as a')
                ->join('t_course_group as b','a.GROUP_NAME','=','b.GROUP_NAME')
                ->join('t_college_section as c','c.section_id','a.SECTION_ID')
                ->where('b.GROUP_ID',$group_id)
                ->where('a.STREAM_ID',$stream_id)
                ->where('a.CLASS_ID',$class_id)
                // ->where('c.section_name',$section[$i]->section_name)
                ->where('a.PROGRAM_ID',$program_id)
                ->where('a.CAMPUS_ID',Auth::user()->CAMPUS_ID)
                ->select('a.ADM_NO','a.NAME','a.GROUP_NAME')
                ->get();
                if(!count($data)){
           return [
                        'Login' => [
                            'response_message'=>"No record found check your login ID",
                            'response_code'=>"1",
                            ],
                            'Details'=>$query,
                    ];
      }
          $query['Test'] = DB::select("select DISTINCT ipd.Exam_name,ipd.Exam_id from IP_Exam_Details ipd left join IP_Exam_Conducted_For ecf on ipd.exam_id=ecf.Exam_id inner join (select t.CAMPUS_ID,ct.GROUP_ID,pn.PROGRAM_ID,t.class_id,ts.STREAM_ID from t_student t left join t_course_track ct on t.COURSE_TRACK_ID=ct.COURSE_TRACK_ID left join t_study_class sc on sc.class_id=t.class_id left join t_program_name pn on t.PROGRAM_ID=pn.PROGRAM_ID left join t_stream ts on ts.STREAM_ID=t.stream_id) ds on ecf.classyear_id=ds.class_id and ecf.stream_id=ds.stream_id and ecf.program_id=ds.program_id and ecf.exam_id=ipd.exam_id and ds.group_id = ecf.group_id and ipd.Test_type_id='".$request->test_type_id."'"
                    );   

          if(!count($query['Test']))
            return [
                        'Login' => [
                            'response_message'=>"No record found",
                            'response_code'=>"1",
                            ],
                            'Details'=>$query,
                    ];
                foreach ($query['Test'] as $key1 => $value1) 
                 {
                 foreach ($data as $key => $value) 
                 {
                    if ($value->GROUP_NAME='M.P.C')
                    {                   
                      $path=public_path().'/Result_sheet/MPC/'.Auth::user()->CAMPUS_ID.'/'.$value1->Exam_id.'/'.$value->ADM_NO.'/'.$request->subject_id;
                    }
                    if ($value->GROUP_NAME='BI.P.C')
                    {
                     $path=public_path().'/Result_sheet/BIPC/'.Auth::user()->CAMPUS_ID.'/'.$value1->Exam_id.'/'.$value->ADM_NO.'/'.$request->subject_id;
                    }
                    // $subjects[$key]->{$value->subject_name}=scandir($path."/");  
                    if(str_replace("/var/www/html/","http://175.101.3.68/",glob($path."/*.{jpg,gif,png,bmp}",GLOB_BRACE)))
                    $a+=1; 
                    else 
                    $d+=1;
                }
               
                if ($a==$hold)
                  {
                  $query['Test'][$key1]->{'status'}='1';
                  $a=0;
                  }
                  else{
                     $query['Test'][$key1]->{'status'}='0';
                      $a=0;
                  }
                  
                }
          // $object = new \stdClass(); 
          // $object->EXAM_ID = $query['Test'][0]->Exam_id;
          // $object->test_type_id = $request->test_type_id;
          // $query['Test'][0]->Percentages= Ipmpc::markDetails($object)["OverAll_Averages"];

           
          // // echo $sum;


          // $query['Test'][0]->total=Ipmpc::markDetails($object)["Add"];
          // $query['Test'][0]->Test_type=$test_types[0]->test_type_name;
          // $query[$test_types[0]->test_type_name][0]->Result=Ipmpc::markDetails($object)["Result"];
 
       return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                            'Details'=>$query,
                            // 'Test'=>$section,
                            // 'Test_Type_Name'=>$test_types[0]->test_type_name,
                            // 'MarkDetails'=>Ipmpc::markDetails($object)["Result"],
                            // 'OverAll_Averages'=>Ipmpc::markDetails($object)["OverAll_Averages"],
                    ];


    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
