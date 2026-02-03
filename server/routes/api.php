<?php

use App\Http\Controllers\clientController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/clients', ClientController::class);