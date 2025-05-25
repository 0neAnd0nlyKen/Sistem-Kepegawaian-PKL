<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('employees/{employee}/naikPangkat', 'App\\Http\\Controllers\\EmployeeController@jabatanPangkatAtas');
        Route::patch('employees/{employee}/naikPangkat/{jabatanBaru}', 'App\\Http\\Controllers\\EmployeeController@naikPangkat');
        Route::post('attendences/bulan', 'App\\Http\\Controllers\\AttendenceController@buatBulanBaru');
        Route::get('attendences/{employee}/{bulan}/{tahun}', 'App\\Http\\Controllers\\AttendenceController@kehadiranBulananPegawai');
        Route::post('attendences/bulanBaru', 'App\\Http\\Controllers\\AttendenceController@buatBulanBaru');
        Route::patch('attendences/{employee}/hadir', 'App\\Http\\Controllers\\AttendenceController@hadir');

        Route::apiResource('employees', 'App\\Http\\Controllers\\EmployeeController');
        Route::apiResource('roles', 'App\\Http\\Controllers\\RoleController');
        Route::apiResource('leaveApplications', 'App\\Http\\Controllers\\LeaveApplicationController');
    });
});

Route::post('login', 'App\\Http\\Controllers\\AuthController@login')->name('login');
Route::post('logout', 'App\\Http\\Controllers\\AuthController@logout')->middleware('auth:sanctum')->name('logout');
