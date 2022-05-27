<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*/Route::get('/', function () {
    return view('welcome');
});
/*/
Route::get('/', 'App\Http\Controllers\HomeController@index');
//5 buttoms
Route::post('/newdevelopment', 'App\Http\Controllers\DevelopmentController@store');
Route::delete('/newdevelopment/{development}', 'App\Http\Controllers\DevelopmentController@remove');


Route::post('/newmeeting', 'App\Http\Controllers\MeetingRequestController@store');
Route::delete('/newmeeting/{meetingrequest}', 'App\Http\Controllers\MeetingRequestController@remove');

Route::post('/newactivity', 'App\Http\Controllers\ActivitieController@store');
Route::delete('/newactivity/{activitie}', 'App\Http\Controllers\ActivitieController@remove');