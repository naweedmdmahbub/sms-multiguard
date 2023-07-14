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


Route::middleware('role:Super-Admin')->group(function(){
});

Route::middleware('role:Admin')->group(function(){

});



Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.list');
Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('/users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::post('/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');

// role permssion routes 
Route::get('/roles/all',[RolePermissionController::class,'roleIndex']);
Route::post('/roles/create',[RolePermissionController::class,'roleStore']);
Route::get('/roles/edit/{id}',[RolePermissionController::class,'roleEdit']);
Route::put('/roles/update/{id}',[RolePermissionController::class,'roleUpdate']);
Route::delete('/roles/delete/{id}',[RolePermissionController::class,'roleDestroy']);

Route::get('/permissions/all',[RolePermissionController::class,'permissionIndex']);
Route::post('/permissions/create',[RolePermissionController::class,'permissionStore']);
Route::delete('/permissions/delete/{id}',[RolePermissionController::class,'permissionDestroy']);





// Route::apiResource('roles', 'RoleController')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
// Route::apiResource('users', 'UserController')->middleware('permission:' . Acl::PERMISSION_USER_MANAGE);
// Route::apiResource('permissions', 'PermissionController')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);

// Custom routes
// Route::put('users/{user}', 'UserController@update');
// Route::get('users/{user}/permissions', 'UserController@permissions')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
// Route::put('users/{user}/permissions', 'UserController@updatePermissions')->middleware('permission:' .Acl::PERMISSION_PERMISSION_MANAGE);
// Route::get('roles/{role}/permissions', 'RoleController@permissions')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);


Route::apiResource('students', StudentController::class);
Route::apiResource('departments', App\Http\Controllers\DepartmentController::class);
Route::get('semesters/students/{semester_id}', 'SemesterController@getStudents');
Route::post('semesters/students/{semester_id}', 'SemesterController@assignStudents');
Route::apiResource('semesters', 'SemesterController');