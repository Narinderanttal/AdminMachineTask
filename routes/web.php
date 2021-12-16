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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\UniversityController::class, 'index']);
Route::any('/create', [App\Http\Controllers\UniversityController::class, 'create']);
Route::any('/add-uni', [App\Http\Controllers\UniversityController::class, 'store']);
Route::any('/update/{id}', [App\Http\Controllers\UniversityController::class, 'show']);
Route::post('/update-uni/{id}', [App\Http\Controllers\UniversityController::class, 'update']);
Route::get('/delete-uni/{id}', [App\Http\Controllers\UniversityController::class, 'destroy']);

Route::get('/student', [App\Http\Controllers\StudentController::class, 'index']);
Route::any('/create-student', [App\Http\Controllers\StudentController::class, 'create']);
Route::any('/add-student', [App\Http\Controllers\StudentController::class, 'store']);
Route::any('/edit/{id}', [App\Http\Controllers\StudentController::class, 'show']);
Route::post('/update-student/{id}', [App\Http\Controllers\StudentController::class, 'update']);
Route::get('/delete-student/{id}', [App\Http\Controllers\StudentController::class, 'destroy']);


