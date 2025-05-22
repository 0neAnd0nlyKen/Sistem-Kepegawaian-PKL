<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('employees', 'App\\Http\\Controllers\\EmployeeController');
    });
});

Route::post('login', 'App\\Http\\Controllers\\AuthController@login');
Route::post('logout', 'App\\Http\\Controllers\\AuthController@logout')->middleware('auth:sanctum');
