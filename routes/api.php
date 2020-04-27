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

Route::group(['middleware' => 'auth:api'], function() {
    Route::resource('users', 'Api\UserController');
    Route::resource('employee', 'Api\EmployeeController');
    Route::resource('attendance', 'Api\AttendanceController');

    Route::post('employee/update-profile', 'Api\EmployeeController@updateAuthProfile')->name('profile.update');

    Route::post('user/update-password', 'Api\UserController@updatePassword')->name('password.update');
    Route::post('send-sms', 'Api\UserController@sendSms')->name('sms.send');
    Route::get('auth-profile', 'Api\AuthController@authProfile')->name('auth.profile');
    Route::get('auth-attendance', 'Api\AttendanceController@getAuthAttendance')->name('auth.attendance');
});

Route::post('login', 'Api\AuthController@login')->name('user.login');
