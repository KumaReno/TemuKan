<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Middleware\VerifyJwtToken;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])
    ->name('api.login');

Route::middleware(VerifyJwtToken::class)->group(function () {
    Route::apiResource('reports', ReportController::class)
        ->names('api.reports');
});
