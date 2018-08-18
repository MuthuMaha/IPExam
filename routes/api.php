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
		// Route::post('auth-check', 'AuthController@tokenAuthCheck'); 
		Route::post('ip-create', 'ExamController@createIPExam');
		Route::delete('ip-delete/{id}', 'ExamController@ipdelete');
		Route::put('edit_exam/{id}', 'ExamController@editExam');
		Route::get('edit_exam_details/{id}', 'ExamController@ipUpdate');
		Route::post('bipc-mpc-marks', 'ExamController@bipc');
		Route::post('result_upload', 'ExamController@mpc');
		Route::post('edit_exam_details/{id}', 'ExamController@examdetailcreate');
		Route::put('edit_exam_details/{id}/{e_id}', 'ExamController@ipeditexamdetails');
		Route::delete('edit_exam_details/{id}/{e_id}', 'ExamController@deleteexamdetails');
		// Route::post('ip-view', 'ExamController@ipview');
	});

