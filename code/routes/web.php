<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkspaceController;
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
})->name('landing');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get("/redirectAuthenticatedUsers", [RedirectAuthenticatedUsersController::class, "home"]);

});
require __DIR__ . '/auth.php';

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    // Main workspace
    Route::get('/projects/{project}/workspace', [WorkspaceController::class, 'index'])->name('workspace');
    
    // Users
    Route::get('/users', [WorkspaceController::class, 'users'])->name('users.index');
    Route::post('/users/{user}/follow', [WorkspaceController::class, 'followUser'])->name('users.follow');

    // Mentorings
    Route::post('/mentorings', [MentoringController::class, 'store'])->name('mentorings.store');
    Route::delete('/mentorings/{mentoring}', [MentoringController::class, 'destroy'])->name('mentorings.destroy');

    // Meetings
    Route::post('/meetings', [MeetingController::class, 'store'])->name('meetings.store');
    Route::put('/meetings/{meeting}', [MeetingController::class, 'updateStatus'])->name('meetings.update');
    Route::delete('/meetings/{meeting}', [MeetingController::class, 'destroy'])->name('meetings.destroy');

    // Tasks
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::put('/tasks/{task}', [TaskController::class, 'markdone'])->name('tasks.update');

    // Chats
    Route::post('/chats', [ChatController::class, 'store'])->name('chats.store');
    Route::get('/chats/messages', [ChatController::class, 'getMessages'])->name('chats.messages');

    // Documents
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    // Projects
    Route::get('/projects/select', [ProjectController::class, 'select'])->name('projects.select');
    Route::resource('projects', ProjectController::class)->except(['edit', 'update']);
    Route::post('/projects/{project}/request-join', [ProjectController::class, 'requestJoin'])->name('projects.request-join');
    Route::post('/projects/{project}/update-status', [ProjectController::class, 'updateStatus'])->name('projects.update-status');

});
