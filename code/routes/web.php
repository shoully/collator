<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MentorDashboardController;
use App\Http\Controllers\MenteeDashboardController;
use App\Http\Controllers\MentoringController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProjectController;
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
    return view('landing');
});

Route::group(['middleware' => 'auth'], function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

    Route::get("/redirectAuthenticatedUsers", [RedirectAuthenticatedUsersController::class, "home"]);

    Route::group(['middleware' => 'checkRole:Mentor'], function () {
        Route::get('/adminDashboard', [MentorDashboardController::class, 'index'])->name('adminDashboard');
    });
    Route::group(['middleware' => 'checkRole:Mentee'], function () {
        Route::get('/userDashboard', [MenteeDashboardController::class, 'index'])->name('userDashboard');
    });
    Route::group(['middleware' => 'checkRole:guest'], function () {
        Route::inertia('/guestDashboard', 'GuestDashboard')->name('guestDashboard');
    });
});
require __DIR__ . '/auth.php';

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    // Main welcome pages
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home2', [HomeController::class, 'listofuser'])->name('home2');
    Route::post('/homefollow/{user}', [HomeController::class, 'fromlistofuser'])->name('home.follow');

    // Mentoring routes
    Route::post('/newmentoring', [MentoringController::class, 'store'])->name('mentoring.store');
    Route::delete('/newmentoring/{mentoring}', [MentoringController::class, 'remove'])->name('mentoring.remove');

    // Meeting routes
    Route::post('/newmeeting', [MeetingController::class, 'store'])->name('meeting.store');
    Route::put('/newmeeting/{meeting}', [MeetingController::class, 'updateStatus'])->name('meeting.updateStatus');
    Route::delete('/newmeeting/{meeting}', [MeetingController::class, 'remove'])->name('meeting.remove');

    // Task routes
    Route::post('/newtask', [TaskController::class, 'store'])->name('task.store');
    Route::delete('/newtask/{task}', [TaskController::class, 'remove'])->name('task.remove');
    Route::put('/newtask/{task}', [TaskController::class, 'markdone'])->name('task.markdone');

    // Chat routes
    Route::post('/newchat', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');

    // Document routes
    Route::post('/documentsadd', [DocumentController::class, 'store'])->name('document.store');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('document.download');

    // Project routes - index and view are available to both mentors and mentees
    // IMPORTANT: More specific routes must come before parameterized routes
    Route::get('/projects/select', [ProjectController::class, 'select'])->name('project.select');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    
    // Project creation (only for mentors) - must come before /projects/{project}
    Route::middleware(['checkRole:Mentor'])->group(function () {
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    });
    
    // Project view and download (available to both mentors and mentees)
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/download', [ProjectController::class, 'download'])->name('projects.download');
    
    // Project request to join (for mentees)
    Route::middleware(['checkRole:Mentee'])->group(function () {
        Route::post('/projects/{project}/request-join', [ProjectController::class, 'requestJoin'])->name('projects.requestJoin');
    });
    
    // Project management (only for mentors)
    Route::middleware(['checkRole:Mentor'])->group(function () {
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::post('/projects/{project}/update-status', [ProjectController::class, 'updateStatus'])->name('projects.updateStatus');
    });
});