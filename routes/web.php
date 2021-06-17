<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EmployeeController;

use App\Http\Controllers\AdminPagesController;
use App\Http\Controllers\EmployeePagesController;
use App\Http\Controllers\StudentPagesController;

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

// Guest user page, which is no need login for access
Route::get('/', [AuthController::class, 'formLogin']);
Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Auth Controller need login to access
Route::group(['middleware' => 'auth'], function() {
    // Any user (admin, employee, student)
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [PagesController::class, 'index'])->name('dashboard');

    // Admin access
    Route::group(['middleware' => 'admin'], function() {

        // CRUD Admin table
        Route::prefix('admin')->group(function() {
            Route::get('create', [AdminController::class, 'form'])->name('adminCreate');
            Route::post('create', [AdminController::class, 'create']);
            Route::get('{user}', [AdminController::class, 'edit'])->name('adminEdit');
            Route::post('{user}', [AdminController::class, 'update']);
            Route::delete('{user}', [AdminController::class, 'delete'])->name('adminDelete');
        });

        // CRUD Employee table 
        Route::prefix('employee')->group(function() {
            Route::get('create', [EmployeeController::class, 'form'])->name('employeeCreate');
            Route::post('create', [EmployeeController::class, 'create']);
            Route::get('{employee}', [EmployeeController::class, 'edit'])->name('employeeEdit');
            Route::post('{employee}', [EmployeeController::class, 'update']);
            Route::delete('{user}', [EmployeeController::class, 'delete'])->name('employeeDelete');
        });

        // CRUD Student table 
        Route::prefix('student')->group(function() {
            Route::get('create', [StudentController::class, 'form'])->name('studentCreate');
            Route::post('create', [StudentController::class, 'create']);
            Route::get('{student}', [StudentController::class, 'edit'])->name('studentEdit');
            Route::post('{student}', [StudentController::class, 'update']);
            Route::delete('{user}', [StudentController::class, 'delete'])->name('studentDelete');
        });

        // Route::get('/dashboard', [AdminPagesController::class, 'index'])->name('dashboard');
        Route::get('/mapel', [PagesController::class, 'mapel']); // move in new controller
    });

    // Employee access
    Route::group(['middleware' => 'employee'], function() {
        // Route::get('/dashboard', [EmployeePagesController::class, 'index'])->name('dashboard');
        Route::get('/settings', [PagesController::class, 'settings']); // move in new controller
        Route::get('/tugas', [PagesController::class, 'tugas']); // move in new controller
        Route::get('/nilai', [PagesController::class, 'nilai']); // move in new controller
    });

    // Student access
    Route::group(['middleware' => 'student'], function() {
        // Route::get('/dashboard', [StudentPagesController::class, 'index'])->name('dashboard');
        Route::get('/kelas', [PagesController::class, 'kelas']); // move in new controller
    });
    
});
