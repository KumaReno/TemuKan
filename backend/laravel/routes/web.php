<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/reports');

Route::resource('reports', ReportController::class)->except(['show']);
