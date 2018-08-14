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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

	Route::post('auth-attempt', 'EmployeeController@empshow');
	Route::post('auth-once', 'AuthController@tokenAuthOnce');
	Route::post('auth-login-using-id', 'AuthController@tokenAuthLoginUsingId');
	Route::post('auth-validate', 'AuthController@tokenAuthValidate');
	Route::post('auth-image', 'AuthController@tokenAuthImage');

	Route::group([ 'middleware' => 'auth:token' ], function () {
		Route::post('auth-check', 'AuthController@tokenAuthCheck'); 
		Route::post('ip-create', 'ExamController@createIPExam');
		Route::post('ip-update', 'ExamController@ipUpdate');
		Route::post('ip-delete', 'ExamController@ipdelete');
		Route::post('ip-view', 'ExamController@ipview');
	});

