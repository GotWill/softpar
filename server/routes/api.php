<?php

use App\Http\Controllers\clientController;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\reportsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/clients', ClientController::class);
Route::apiResource('/demands', DemandController::class);
Route::patch('/demands/{demand}/status', [DemandController::class, 'updateStatus']);
Route::get('/reports/client/{id}', [reportsController::class, 'index']);