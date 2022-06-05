<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});




Route::group(['middleware' => 'auth'], function() {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

    Route::get("/redirectAuthenticatedUsers", [RedirectAuthenticatedUsersController::class, "home"]);

    Route::group(['middleware' => 'checkRole:Mentor'], function() {
        Route::inertia('/adminDashboard', 'AdminDashboard')->name('adminDashboard');
    });
    Route::group(['middleware' => 'checkRole:Mentee'], function() {
        Route::inertia('/userDashboard', 'UserDashboard')->name('userDashboard');
    });
    Route::group(['middleware' => 'checkRole:guest'], function() {
        Route::inertia('/guestDashboard', 'GuestDashboard')->name('guestDashboard');
    });
});
require __DIR__.'/auth.php';

//main welcome Mentee
Route::get('/home', 'App\Http\Controllers\HomeController@index');
//main 2 welcome Mentor
Route::get('/home2', 'App\Http\Controllers\HomeController@listofuser');

//Mentor click follow
Route::post('/homefollow/{user}', 'App\Http\Controllers\HomeController@fromlistofuser');
 

//5 buttoms
Route::post('/newmentoring', 'App\Http\Controllers\MentoringController@store');
Route::delete('/newmentoring/{mentoring}', 'App\Http\Controllers\MentoringController@remove');


Route::post('/newmeeting', 'App\Http\Controllers\MeetingRequestController@store');
Route::delete('/newmeeting/{meetingrequest}', 'App\Http\Controllers\MeetingRequestController@remove');

Route::post('/newactivity', 'App\Http\Controllers\TaskController@store');
Route::delete('/newactivity/{activitie}', 'App\Http\Controllers\TaskController@remove');
Route::put('/newactivity/{activitie}', 'App\Http\Controllers\TaskController@markdone');

