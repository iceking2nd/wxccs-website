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

Route::post('/login','Auth\LoginController@login');
Route::post('/logout','Auth\LoginController@logout');
Route::post('/token/refresh','Auth\LoginController@refresh');
Route::post('/user/profile/update','System\ProfileController@update')->middleware('auth:api');
Route::post('/user/password/update','System\PasswordController@update')->middleware('auth:api');


Route::get('/system/backgroundvideo/randomone','System\BackGroundVideoController@randomone');
Route::get('/5ewin/elolist/getallaccounts','Fewin\ELOListController@GetAllAccounts');
Route::post('/5ewin/elolist/account','Fewin\ELOListController@store');

Route::group([ 'prefix' => 'blog', 'as' => 'blog.' ],function (){
    Route::resource('article','Blog\ArticleController')->only(['index','show','store','update']);
});
