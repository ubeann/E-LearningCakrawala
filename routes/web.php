<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;

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

// Pages Controller using for static website
Route::get('/', [PagesController::class, 'home']);
Route::get('/settings', [PagesController::class, 'settings']); // move in new controller
Route::get('/kelas', [PagesController::class, 'kelas']); // move in new controller
Route::get('/tugas', [PagesController::class, 'tugas']); // move in new controller
Route::get('/mapel', [PagesController::class, 'mapel']); // move in new controller
Route::get('/nilai', [PagesController::class, 'nilai']); // move in new controller
