<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
   
   protected $table='IP_Query_Response';
   protected $primaryKey='response_id';

   protected $fillable=['query_id', 'response_text', 'response_by', 'created_by', 'updated_by', 'created_at', 'updated_at'];


   public static function queryResponse($data){

   	$qdata=Response::create([
   		'query_id'=>$data->Query_Id,
   		'response_text'=>$data->Response_Text,
   		'response_by'=>Auth::user()->PAYROLL_ID
   	]);
   	return $qdata;

   }

   public static function getqueryResponse($data){

   	$qdata=Response::where([
   		'response_by'=>Auth::user()->PAYROLL_ID
   	])->get();
   	return $qdata;

   }
   public static function updatequeryResponse($data){

   	$qdata=Response::where('response_id',$data->response_id)->update([
   		'query_id'=>$data->query_id,
   		'response_text'=>$data->response_text
   	]);
   	return $qdata;

   }

}
