<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarnesController;

Route::apiResource('carnes', CarnesController::class)->only(['index', 'store', 'show']);
