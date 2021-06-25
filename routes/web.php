<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;

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

// Guest pages, which is no need login for access
Route::get('/', [AuthController::class, 'formLogin']);
Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/heldesk', [PagesController::class, 'helpdesk'])->name('helpdesk');

// Auth Controller need login to access
Route::group(['middleware' => 'auth'], function() {

    // Any user (admin, employee, student)
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [PagesController::class, 'index'])->name('dashboard');
    Route::get('/kelas', [RoomController::class, 'index'])->name('roomIndex');
    Route::get('/setting', [PagesController::class, 'setting'])->name('setting');
    Route::post('setting', [PagesController::class, 'update']);

    // Admin access
    Route::group(['middleware' => 'admin'], function() {

        // CRUD Admin table
        Route::prefix('admin')->group(function() {
            Route::get('create', [AdminController::class, 'form'])->name('adminCreate');
            Route::post('create', [AdminController::class, 'create']);
            Route::get('{user}', [AdminController::class, 'edit'])->name('adminEdit');
            Route::post('{user}', [AdminController::class, 'update']);
            Route::patch('{user}', [AdminController::class, 'setting']);
            Route::delete('{user}', [AdminController::class, 'delete'])->name('adminDelete');
        });

        // CRUD Employee table 
        Route::prefix('employee')->group(function() {
            Route::get('create', [EmployeeController::class, 'form'])->name('employeeCreate');
            Route::post('create', [EmployeeController::class, 'create']);
            Route::get('{employee}/edit', [EmployeeController::class, 'edit'])->name('employeeEdit');
            Route::post('{employee}/edit', [EmployeeController::class, 'update']);
            Route::delete('{user}', [EmployeeController::class, 'delete'])->name('employeeDelete');
        });

        // CRUD Student table 
        Route::prefix('student')->group(function() {
            Route::get('create', [StudentController::class, 'form'])->name('studentCreate');
            Route::post('create', [StudentController::class, 'create']);
            Route::get('{student}/edit', [StudentController::class, 'edit'])->name('studentEdit');
            Route::post('{student}/edit', [StudentController::class, 'update']);
            Route::delete('{user}', [StudentController::class, 'delete'])->name('studentDelete');
        });

        // CRUD Rooms
        Route::prefix('kelas')->group(function() {
            Route::get('create', [RoomController::class, 'form'])->name('roomCreate');
            Route::post('create', [RoomController::class, 'create']);
            Route::get('{room}/edit', [RoomController::class, 'edit'])->name('roomEdit');
            Route::post('{room}/edit', [RoomController::class, 'update']);
            Route::delete('{room}', [RoomController::class, 'delete'])->name('roomDelete');
        });
    });

    // Tenaga Didik access
    Route::group(['middleware' => 'tendik'], function() {

        // CRUD Task
        Route::prefix('tugas')->group(function() {
            Route::get('{room}/create', [AssignmentController::class, 'form'])->name('taskCreate');
            Route::post('{room}/create', [AssignmentController::class, 'create']);
            Route::get('{assignment}/edit', [AssignmentController::class, 'edit'])->name('taskEdit');
            Route::post('{assignment}/edit', [AssignmentController::class, 'update']);
            Route::delete('{assignment}', [AssignmentController::class, 'delete'])->name('taskDelete');
        });

        // Create & Update Grade
        Route::prefix('tugas')->group(function() {
            Route::post('{assignment}/{student}', [GradeController::class, 'create'])->name('grading');
            Route::patch('{assignment}/{student}', [GradeController::class, 'update']);
        });
    });

    // Student access
    Route::group(['middleware' => 'student'], function() {
        // Grade page
        Route::get('nilai', [GradeController::class, 'index'])->name('grade');
        // CRUD Submission
        Route::prefix('tugas')->group(function() {
            Route::post('{assignment}', [SubmissionController::class, 'create'])->name('submission');
            Route::patch('{assignment}', [SubmissionController::class, 'update'])->name('submissionEdit');
            Route::delete('{assignment}/delete', [SubmissionController::class, 'delete'])->name('submissionDelete');
        });
    });
   
    // Admin and Employee access
    Route::group(['middleware' => 'adminEmployee'], function() {
        Route::get('kelas/{room}', [RoomController::class, 'detail'])->name('roomDetail');
    });

    // Employee and Student access
    Route::group(['middleware' => 'employeeStudent'], function() {

        // Task pages
        Route::prefix('tugas')->group(function() {
            Route::get('/', [AssignmentController::class, 'index'])->name('taskIndex');
            Route::get('{assignment}', [AssignmentController::class, 'detail'])->name('taskDetail');
        });

        // Profile Student page
        Route::get('student/{student}', [StudentController::class, 'detail'])->name('studentDetail');

        // Download submission
        Route::get('submission/{submission}', [SubmissionController::class, 'download'])->name('submissionDownload');
    });
});