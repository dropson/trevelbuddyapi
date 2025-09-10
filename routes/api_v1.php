<?php

declare(strict_types=1);

use App\Http\Controllers\API\V1\ProfileController;
use App\Http\Controllers\API\V1\Trip\TripOwnerController;
use App\Http\Controllers\API\V1\Trip\TripStatusController;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('verified')->group(function () {

        Route::prefix('trips/owner')->group(function () {
            Route::get('/', [TripOwnerController::class, 'index']);
            Route::post('/', [TripOwnerController::class, 'store']);
            Route::get('/{trip:slug}', [TripOwnerController::class, 'show']);
            Route::put('/{trip:slug}', [TripOwnerController::class, 'update']);
            Route::delete('/{trip:slug}', [TripOwnerController::class, 'destroy']);
        });

        Route::post('trips/{trip:slug}/status', TripStatusController::class);
    });

    Route::get('/me', function (Request $request) {
        return new UserResource($request->user()->load('profile'));
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::post('/update', [ProfileController::class, 'updateProfile']);
        Route::post('/avatar', [ProfileController::class, 'setAvatar']);
        Route::delete('/avatar', [ProfileController::class, 'deleteAvatar']);
        Route::post('/banner', [ProfileController::class, 'setBanner']);
        Route::delete('/banner', [ProfileController::class, 'deleteBanner']);
    });
});
