<?php

use App\Http\Controllers\Api\ReportController;
use Illuminate\Support\Facades\Route;

Route::apiResource('reports', ReportController::class)
    ->names('api.reports');
