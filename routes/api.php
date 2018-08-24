<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

	Route::post('auth-attempt', 'EmployeeController@empshow');

	Route::group([ 'middleware' => 'auth:token' ], function () {
		Route::post('auth-check', 'EmployeeController@check');  
		Route::post('ip-create', 'ExamController@createIPExam');
		Route::delete('ip-delete/{id}', 'ExamController@ipdelete');
		Route::put('edit_exam/{id}', 'ExamController@editExam');
		Route::get('edit_exam_details/{id}', 'ExamController@ipUpdate');
		Route::post('bipc-mpc-marks', 'ExamController@bipc');
		Route::put('bipc-mpc-marks', 'ExamController@bipcedit');
		Route::delete('bipc-mpc-marks', 'ExamController@bipcdelete');
		Route::post('result_upload', 'ExamController@mpc');
		Route::post('edit_exam_details/{id}', 'ExamController@examdetailcreate');
		Route::put('edit_exam_details/{id}/{e_id}', 'ExamController@ipeditexamdetails');
		Route::delete('edit_exam_details/{id}/{e_id}', 'ExamController@deleteexamdetails');
		// Route::post('ip-view', 'ExamController@ipview');
		Route::delete('deleteresultimages','ExamController@deleteresult');
		Route::get('resultimagesview','ExamController@resultimagesview');
	});



//let these be here for somtime
   Route::get('groups','BaseController@groups');
   Route::get('class_years/{group_id}','BaseController@class_year_wrt_group');
   Route::get('streams/{group_id}/{class_id}','BaseController@stream_wrt_group_class_year');
   Route::get('programs/{stream_id}/{class_id}','BaseController@programs_wrt_stream_class_year');


//student Login Api's 
Route::get('student/{stud_id}/profile','StudentController@profile_details');
Route::get('student/{stud_id}/reports_card','StudentController@written_tests');


	
