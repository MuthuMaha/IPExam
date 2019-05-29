<?php

namespace App;
use App\Query;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
   
   protected $table='IP_Query_Response';
   protected $primaryKey='response_id';

   protected $fillable=['query_id', 'response_text', 'response_by','type', 'created_by', 'updated_by', 'created_at', 'updated_at'];

     public static function query()
    {
        return $this->hasOne('App\Query','query_id', 'query_id');
    }
   public static function queryResponse($data){
              if(isset(Auth::user()->PAYROLL_ID))
                 	$qdata=Response::create([
                 		'query_id'=>$data->Query_Id,
                 		'response_text'=>$data->Response_Text,
                 		'response_by'=>Auth::user()->PAYROLL_ID,
                    'type'=>'1'
                 	]);
                 if (isset(Auth::user()->ADM_NO))
                    $qdata=Response::create([
                    'query_id'=>$data->Query_Id,
                    'response_text'=>$data->Response_Text,
                    'response_by'=>Auth::user()->ADM_NO,
                    'type'=>'0'
                  ]);
                 	   return [
                              'Login' => [
                                  'response_message'=>"success",
                                  'response_code'=>"1",
                                  ],
                              'Message'=>'Response Created Successfully',
                          ];

   }

   public static function getqueryResponse($data)
   {

      $qdata=Query::select('query_id','query_text','subject_id','exam_id')->where(
      'pointed_to',Auth::user()->PAYROLL_ID)->where(
      'query_id',$data->Query_Id)->with('response')->get();

    return [
                'Login' => [
                    'response_message'=>"success",
                    'response_code'=>"1",
                    ],
                'Query'=>$qdata,
            ];
   //  $qdata=DB::table('IP_Queries as q')

   //  ->select('r.response_id','r.response_text','r.response_by','q.query_id','q.query_text','q.pointed_by','q.stud_id','q.exam_id','q.subject_id','q.pointed_to')
   //  ->join('IP_Query_Response as r','r.query_id','=','q.query_id')
   //  ->where('r.response_by',Auth::user()->PAYROLL_ID)
   //  ->where('q.query_id',$data->Query_Id)
   //  ->get();

   // return [
   //              'Login' => [
   //                  'response_message'=>"success",
   //                  'response_code'=>"1",
   //                  ],
   //              'Details'=>$qdata,
   //          ];

   }
   public static function getqueryResponseList($data){

  
      $qdata=DB::table('IP_Queries as a')
              ->join('scaitsqb.t_student_bio as b','a.stud_id','=','b.ADM_NO')
              ->join('t_parent_details as c','a.stud_id','=','c.ADM_NO')
              ->join('0_subjects as d','d.subject_id','=','a.subject_id')
              ->where([

                   'a.pointed_to'=>Auth::user()->PAYROLL_ID,

                 ])
              ->select('a.query_id','a.query_text','a.stud_id','a.created_at','b.NAME as student_name','c.PARENT_NAME as parent_name','d.subject_name')
              ->get();

   return [
                'Login' => [
                    'response_message'=>"success",
                    'response_code'=>"1",
                    ],
                'Details'=>$qdata,
            ];

   }
   public static function updatequeryResponse($data){

   	$qdata=Response::where('response_id',$data->Response_Id)->update([
   		'query_id'=>$data->Query_Id,
   		'response_text'=>$data->Response_Text
   	]);
      return [
                'Login' => [
                    'response_message'=>"success",
                    'response_code'=>"1",
                    ],
                'Message'=>'Response Updated Successfully',
            ];

   }

}
