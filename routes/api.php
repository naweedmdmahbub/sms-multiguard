<?php

use App\Http\Controllers\COGSController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::middleware('auth:api')->get('/session', function () {
//     return session()->all();
// });
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('role:Admin')->group(function(){

});


Route::get('/get-dashboard-data', [App\Http\Controllers\HomeController::class, 'getDashboardData'])->name('home.getDashboardData');

Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.list');
Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('/users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::post('/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');

Route::apiResource('departments', App\Http\Controllers\DepartmentController::class);
// Route::apiResource('students', App\Http\Controllers\StudentController::class);

Route::get('/students', [App\Http\Controllers\StudentController::class, 'index'])->name('students.index');
Route::get('/students/{id}', [App\Http\Controllers\StudentController::class, 'show'])->name('students.show');
Route::post('/students/{id}', [App\Http\Controllers\StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{id}', [App\Http\Controllers\StudentController::class, 'destroy'])->name('students.delete');
Route::post('/students', [App\Http\Controllers\StudentController::class, 'store'])->name('students.store');

Route::get('semesters/students/{semester_id}', 'SemesterController@getStudents');
Route::post('semesters/students/{semester_id}', 'SemesterController@assignStudents');
Route::apiResource('semesters', 'SemesterController');
