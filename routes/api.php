<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('employees', 'App\\Http\\Controllers\\EmployeeController');
});
