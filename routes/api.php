<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('employees/{employee}/naikPangkat', 'App\\Http\\Controllers\\EmployeeController@jabatanPangkatAtas');
        Route::patch('employees/{employee}/naikPangkat/{jabatanBaru}', 'App\\Http\\Controllers\\EmployeeController@naikPangkat');

        Route::apiResource('employees', 'App\\Http\\Controllers\\EmployeeController');
        Route::apiResource('roles', 'App\\Http\\Controllers\\RoleController');
    });
});

Route::post('login', 'App\\Http\\Controllers\\AuthController@login')->name('login');
Route::post('logout', 'App\\Http\\Controllers\\AuthController@logout')->middleware('auth:sanctum')->name('logout');
