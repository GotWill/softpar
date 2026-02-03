<?php

use App\Http\Controllers\clientController;
use App\Http\Controllers\DemandController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/clients', ClientController::class);
Route::apiResource('/demands', DemandController::class);
Route::patch('/demands/{demand}/status', [DemandController::class, 'updateStatus']);