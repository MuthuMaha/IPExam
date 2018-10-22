<?php

namespace App;
use Auth;
use DB;
use App\Response;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
   protected $table='IP_Queries';
   protected $primaryKey='query_id';

   protected $fillable=[ 'query_id', 'query_text', 'pointed_by', 'stud_id', 'exam_id', 'subject_id', 'pointed_to'];

   public function response(){

       return $this->hasMany('App\Response','query_id','query_id');
   }

   public function student(){

       return $this->hasMany('App\BaseModels\Student','ADM_NO','stud_id');
   }

   public function parent(){

       return $this->hasMany('App\BaseModels\Parents','ADM_NO','stud_id');
   }

   public function employee(){

       return $this->hasMany('App\Employee','PAYROLL_ID','pointed_to');
   }

   public static function queryRise($data){

    $employee=DB::table('t_employee as a')
              ->join('IP_Exam_Section as b','b.EMPLOYEE_ID','=','a.PAYROLL_ID')
              ->where('a.CAMPUS_ID',Auth::user()->CAMPUS_ID)
              ->select('a.PAYROLL_ID')
              ->get();

   	$name=Parent_details::where('ADM_NO',Auth::id())->get();

   	$qdata=Query::create([
   		'query_text'=>$data->Query_Text,
   		'pointed_by'=>$name[0]->PARENT_NAME,
   		'stud_id'=>Auth::user()->ADM_NO,
   		'exam_id'=>$data->Exam_Id,
   		'subject_id'=>$data->Subject_Id,
   		'pointed_to'=>$employee[0]->PAYROLL_ID,
   	]);
    $qdata1=Response::create([
      'query_id'=>$qdata->query_id,
      'response_text'=>$data->Response_Text,
      'response_by'=>Auth::user()->ADM_NO,
      'type'=>'0'
    ]);
     return [
                'Login' => [
                    'response_message'=>"success",
                    'response_code'=>"1",
                    ],
                'Message'=>'Query Created Successfully',
            ];

   }
   public static function getqueryRise($data){
    if(isset(Auth::user()->ADM_NO))
      $qdata=Query::join('0_subjects as b','IP_Queries.subject_id','=','b.subject_id')
                ->where('IP_Queries.stud_id',Auth::user()->ADM_NO)
                ->where('IP_Queries.query_id',$data->Query_Id)->with('response')
                ->select('b.subject_name','IP_Queries.query_id','IP_Queries.query_text','IP_Queries.subject_id','IP_Queries.exam_id')
                ->get();

    if(isset(Auth::user()->PAYROLL_ID))
      $qdata=Query::join('0_subjects as b','IP_Queries.subject_id','=','b.subject_id')
                ->where('IP_Queries.pointed_to',Auth::user()->PAYROLL_ID)
                ->where('IP_Queries.query_id',$data->Query_Id)->with('response')
                ->select('b.subject_name','IP_Queries.query_id','IP_Queries.query_text','IP_Queries.subject_id','IP_Queries.exam_id')
                ->get();

    return [
                'Login' => [
                    'response_message'=>"success",
                    'response_code'=>"1",
                    ],
                'Query'=>$qdata[0],
            ];

   }
   public static function getqueryList($data){

      // $qdata=Query::select('query_id','query_text','stud_id','created_at','pointed_to')->where([

      //             'stud_id'=>Auth::user()->ADM_NO,

      //           ])->with(['student' => function($query) {
      //               $query->select('SURNAME','ADM_NO');
      //           }])->with(['employee' => function($query) {
      //               $query->select('SURNAME','PAYROLL_ID');
      //           }])->get();
      $qdata=DB::table('IP_Queries as a')
                ->join('t_student as b','a.stud_id','=','b.ADM_NO')
                ->join('t_employee as c','a.pointed_to','=','c.PAYROLL_ID')
                ->join('0_subjects as d','a.subject_id','=','d.subject_id')
                ->where('stud_id',Auth::user()->ADM_NO)
                ->select('a.query_id','a.query_text','a.stud_id','a.created_at','a.pointed_to','b.NAME as student_name','c.USER_NAME as employee_name','b.ADM_NO as student_id','c.PAYROLL_ID as employee_id','a.subject_id','a.exam_id','d.subject_name')
                ->get();
      // $qdata= return static::where('ADM_NO','=',$stud_id)->with('program','stream','class_year','campus','section','parent')->get();

   	return [
                'Login' => [
                    'response_message'=>"success",
                    'response_code'=>"1",
                    ],
                'Query'=>$qdata,
            ];

   }
   public static function updatequery($data){

   		$qdata=Query::where('query_id',$data->query_id)->update([
   		'query_text'=>$data->query_text,
   		'exam_id'=>$data->EXAM_ID,
   		'subject_id'=>$data->SUBJECT_ID,
   		'pointed_to'=>$data->pointed_to

   	]);
   	   return [
                'Login' => [
                    'response_message'=>"success",
                    'response_code'=>"1",
                    ],
                'Message'=>'Query Updated Successfully',
            ];

   }
}
