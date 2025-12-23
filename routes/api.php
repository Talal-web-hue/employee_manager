<?php

use App\Http\Controllers\EmployeeController;
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