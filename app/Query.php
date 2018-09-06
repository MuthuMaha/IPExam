<?php

namespace App;
use Auth;
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

   public static function queryRise($data){

   	$name=Parent_details::where('ADM_NO',Auth::id())->get();
   	$qdata=Query::create([

   		'query_text'=>$data->Query_Text,
   		'pointed_by'=>$name[0]->PARENT_NAME,
   		'stud_id'=>Auth::user()->ADM_NO,
   		'exam_id'=>$data->Exam_Id,
   		'subject_id'=>$data->Subject_Id,
   		'pointed_to'=>$data->Pointed_To,

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

   		$qdata=Query::where([

   		'stud_id'=>Auth::user()->ADM_NO,

   	])->with('response')->get();

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
