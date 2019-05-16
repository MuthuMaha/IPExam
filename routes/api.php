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
		Route::get('employeelist', 'EmployeeController@emplist');
		Route::get('examlist', 'ExamController@examlist');
		Route::get('examdelete', 'ExamController@examdelete');
		Route::get('sectionlist', 'ExamController@sectionlist');
		Route::get('skipsection', 'ExamController@skipsection');
		Route::get('campsection', 'ExamController@campsection');
		Route::get('subjectlist', 'SubjectController@sublist');
		Route::get('studlist', 'SubjectController@studlist');
		Route::get('updatemanage', 'SubjectController@updatemanage');
		Route::get('uploadstatus', 'SubjectController@uploadstatus');
		Route::get('notify', 'SubjectController@notify');
		Route::post('subjectadd', 'SubjectController@subadd');
		Route::post('subjectup', 'SubjectController@subupdate');
		Route::post('subjectdel', 'SubjectController@subdelete');

		//IP Exam CRUD 

		Route::post('ip-create', 'ExamController@createIPExam');
		Route::post('ip-name', 'ExamController@createIPExamname');
		Route::delete('ip-delete/{id}', 'ExamController@ipdelete');
		Route::post('edit_exam', 'ExamController@editExam');
		Route::get('edit_exam_details', 'ExamController@ipUpdate');
		// Route::get('edit_ip_view/{id}', 'ExamController@ipUpdate');
		Route::post('ip-view', 'ExamController@ipview');
		Route::post('edit_exam_details/{id}', 'ExamController@examdetailcreate');
		Route::put('edit_exam_details/{id}/{e_id}', 'ExamController@ipeditexamdetails');
		Route::delete('edit_exam_details/{e_id}', 'ExamController@deleteexamdetails');

	Route::group([ 'middleware' => 'auth:token' ], function () {

		//BIPC_MPC

		Route::post('bipc-mpc-marks', 'ExamController@bipc');
		Route::put('bipc-mpc-marks', 'ExamController@bipcedit');
		Route::delete('bipc-mpc-marks', 'ExamController@bipcdelete');

		//Pictorial/Grapical Representation

		Route::post('analytical_info', 'ExamController@markDetails');
		Route::post('performance', 'ExamController@performancechart');
		Route::post('performance_month', 'ExamController@performancemonth');
		Route::post('test_type', 'ExamController@test_type');
		Route::post('result_details', 'ExamController@result_details');

		//Result Image CRUD

		Route::post('result_upload', 'ExamController@mpc');
		Route::post('deleteresultimages','ExamController@deleteresult');
		Route::post('resultimagesview','ExamController@resultimagesview');

		//Query API

		Route::post('rise_query', 'ExamController@queryRise');
		Route::post('getqueryRise', 'ExamController@getqueryRise');
		Route::post('getqueryList', 'ExamController@getqueryList');
		// Route::put('rise_query', 'ExamController@updatequery');
		Route::delete('rise_query/{Query_Id}', 'ExamController@deleteQuery');

		//Response API

		Route::post('query_response', 'ExamController@queryResponse');
		Route::post('getqueryResponse', 'ExamController@getqueryResponse');
		Route::post('getqueryResponseList', 'ExamController@getqueryResponseList');
		// Route::put('query_response', 'ExamController@updatequeryResponse');
		Route::delete('query_response/{Response_Id}', 'ExamController@deleteResponse');

		//let these be here for sometime

		Route::get('groups','BaseController@groups');
		Route::get('class_years/{group_id}','BaseController@class_year_wrt_group');
		Route::get('streams/{group_id}/{class_id}','BaseController@stream_wrt_group_class_year');
		Route::get('programs/{stream_id}/{class_id}','BaseController@programs_wrt_stream_class_year');
		Route::get('sections/{program_id}/{stream_id}/{class_id}','BaseController@sections_programs_wrt_stream_class_year');
		Route::post('student_upload','BaseController@student_upload');
		Route::post('exam_upload_details','BaseController@exam_upload_details');
		Route::post('upload_marks','BaseController@student_upload_marks');


		//student Login Api's 

		Route::post('profile_details','StudentController@profile_details');
		Route::post('reports_card','StudentController@written_tests');
		Route::post('reports_card_date','StudentController@written_tests_date');
	});





	
