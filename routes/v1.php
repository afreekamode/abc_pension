<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

//Registration  Endpoits *******************************************************
Route::prefix('/pension')->group(function(){

Route::post('login', 'Auth\LoginController@authenticate');

Route::post('register/admin', 'Auth\RegisterController@admin');//has a role of 0

Route::post('register/employer', 'Auth\RegisterController@employer');

Route::post('register/employee', 'Auth\RegisterController@employee');//has a role of 1
//////////End of Registration Endpoits//////////////


//Verify account
Route::post('verify/{code}/{email}', 'Auth\VerificationController@verify');

//forgot Password
Route::post('password/verify', 'Auth\ForgotPasswordController@verifyPassword');

//Reset password for a new password
Route::put('password/reset', 'Auth\ResetPasswordController@reset');

Route::post('/logout', 'Auth\LoginController@logout')->middleware('auth:api');



//Users  Endpoits *******************************************************
//This is the route group, every authenticated route with passport token should go in here
Route::group(['middleware' => 'auth:api'], function () {
    //Show active user i.e. current logged in user
    Route::get('/all', 'UserProfileController@index');

    //show one user
    Route::get('/profile', 'UserProfileController@employee');

    //show one employer
    Route::get('/employer', 'UserProfileController@employer');

    //Edit user ac count
    Route::post('/user/edit', 'UserProfileController@update_employee_profile');

    //Change Password
    Route::put('/user/password', 'UserProfileController@password');

    //Delete user account
    Route::delete('/user/delete', 'UserProfileController@destroy');

    //////////End of User Endpoits//////////////

  //Pension Remitance Endpoits *******************************************************

    Route::get('/transaction/key/{trxn_key}', 'Trxn\NewTransactionsController@show'); //get a transaction key

    Route::post('/transaction/rsa', 'Trxn\NewTransactionsController@credit_employee')->middleware('employer');//credit employee

});
});

Route::get('verify', 'Auth\VerificationController@generatePin');

//Authentication Route
// Auth::routes();