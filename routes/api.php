<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AdminMid;
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

// sms routes
Route::post('/send_sms','VerifyPhoneController@send_sms');
Route::post('/verify_sms','VerifyPhoneController@verify_sms');

//admins routes
Route::post('/admin/login','AdminController@login');
Route::middleware(AdminMid::class)->group(function (){
    Route::post('/admin/logout','AdminController@logout');
    // category managment
    Route::post('/category','CategoryController@addCategory');
    Route::put('/category','CategoryController@editCategory');
    Route::delete('/category','CategoryController@deleteCategory');
    // subCategory managment
    Route::post('/subCategory','CategoryController@addSubCategory');
    Route::put('/subCategory','CategoryController@editSubCategory');
    Route::delete('/subCategory','CategoryController@deleteSubCategory');
});

// category routes
Route::get('/category','CategoryController@index');