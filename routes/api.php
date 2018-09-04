<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!muthu
|
*/
	Route::post('auth-attempt', 'EmployeeController@empshow');

	Route::group([ 'middleware' => 'auth:token' ], function () {
		//IP Exam CRUD 

		Route::post('ip-create', 'ExamController@createIPExam');
		Route::delete('ip-delete/{id}', 'ExamController@ipdelete');
		Route::put('edit_exam/{id}', 'ExamController@editExam');
		Route::get('edit_exam_details/{id}', 'ExamController@ipUpdate');
		// Route::post('ip-view', 'ExamController@ipview');
		Route::post('edit_exam_details/{id}', 'ExamController@examdetailcreate');
		Route::put('edit_exam_details/{id}/{e_id}', 'ExamController@ipeditexamdetails');
		Route::delete('edit_exam_details/{id}/{e_id}', 'ExamController@deleteexamdetails');

		//BIPC_MPC

		Route::post('bipc-mpc-marks', 'ExamController@bipc');
		Route::put('bipc-mpc-marks', 'ExamController@bipcedit');
		Route::delete('bipc-mpc-marks', 'ExamController@bipcdelete');

		//Pictorial/Grapical Representation

		Route::get('analytical_info', 'ExamController@markDetails');
		Route::get('performance', 'ExamController@performancechart');

		//Result Image CRUD

		Route::post('result_upload', 'ExamController@mpc');
		Route::delete('deleteresultimages','ExamController@deleteresult');
		Route::get('resultimagesview','ExamController@resultimagesview');

		//Query API

		Route::post('rise_query', 'ExamController@queryRise');
		Route::get('rise_query', 'ExamController@getqueryRise');
		Route::put('rise_query', 'ExamController@updatequery');
		Route::delete('rise_query', 'ExamController@deleteQuery');

		//Response API

		Route::post('query_response', 'ExamController@queryResponse');
		Route::get('query_response', 'ExamController@getqueryResponse');
		Route::put('query_response', 'ExamController@updatequeryResponse');
		Route::delete('query_response', 'ExamController@deleteResponse');

		//let these be here for sometime

		Route::get('groups','BaseController@groups');
		Route::get('class_years/{group_id}','BaseController@class_year_wrt_group');
		Route::get('streams/{group_id}/{class_id}','BaseController@stream_wrt_group_class_year');
		Route::get('programs/{stream_id}/{class_id}','BaseController@programs_wrt_stream_class_year');

		//student Login Api's 

		Route::get('profile_details','StudentController@profile_details');
		Route::get('student/{stud_id}/reports_card/{test_type_id}','StudentController@written_tests');
		Route::get('student/{stud_id}/reports_card/{test_type_id}/{test_date}','StudentController@written_tests_date');
	});





	
