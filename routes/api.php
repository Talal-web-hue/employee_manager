<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// User (manager) Api

Route::post('/register' , [UserController::class , 'register']);
Route::post('/login' , [UserController::class , 'login']);
Route::post('/logout' , [UserController::class , 'logout'])->middleware('auth:sanctum');

// employee Api

Route::post('/store' , [EmployeeController::class , 'store'])->middleware('auth:sanctum');
Route::put('/update/{employeeNumber}' , [EmployeeController::class , 'update']);
Route::get('/index/{employeeNumber}' , [EmployeeController::class , 'show'])->middleware('auth:sanctum');
Route::delete('/delete/{employeeNumber}' , [EmployeeController::class , 'destroy'])->middleware('auth:sanctum');
Route::get('/showAllEmployee' , [EmployeeController::class , 'index'])->middleware('auth:sanctum');
Route::get('searchEmployee' , [EmployeeController::class , 'search']);

// department Api 
Route::post('storeDept' , [DepartmentController::class , 'store']);
Route::put('updateDept/{deptId}' , [DepartmentController::class , 'update']);
Route::delete('deleteDept/{deptId}' , [DepartmentController::class , 'delete']);
Route::get('employeeNumbers' , [DepartmentController::class , 'getEmployeesCountInDepartment']);

//  Task Api
Route::post('storeTask' , [TaskController::class, 'store']);
Route::put('updateTask/{idTaks}' , [TaskController::class, 'update']);
Route::delete('deleteTask/{idTaks}' , [TaskController::class, 'delete']);


//  Leaves Api

Route::post('storeLeave' , [LeaveController::class, 'store']);
Route::put('updateLeave/{idLeave}' , [LeaveController::class, 'update']);
Route::delete('deleteLeave/{idLeave}' , [LeaveController::class, 'delete']);
