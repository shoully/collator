<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

//Mentee
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Mentor
Route::get('/dashboard2', 'App\Http\Controllers\HomeController@index');


require __DIR__.'/auth.php';

//main welcome
Route::get('/home', 'App\Http\Controllers\HomeController@index');
//main 2 welcome
Route::get('/home2', 'App\Http\Controllers\HomeController@index');



//5 buttoms
Route::post('/newmentoring', 'App\Http\Controllers\MentoringController@store');
Route::delete('/newmentoring/{mentoring}', 'App\Http\Controllers\MentoringController@remove');


Route::post('/newmeeting', 'App\Http\Controllers\MeetingRequestController@store');
Route::delete('/newmeeting/{meetingrequest}', 'App\Http\Controllers\MeetingRequestController@remove');

Route::post('/newactivity', 'App\Http\Controllers\ActivitieController@store');
Route::delete('/newactivity/{activitie}', 'App\Http\Controllers\ActivitieController@remove');
Route::put('/newactivity/{activitie}', 'App\Http\Controllers\ActivitieController@markdone');

