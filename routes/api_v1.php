<?php

declare(strict_types=1);

use App\Http\Controllers\API\V1\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [ProfileController::class, 'show']);

    Route::middleware('verified')->group(function () {
        // create trip and another things with verified
    });
});
