<?php

use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DailyUpdateController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;






Route::prefix('v1')->group(
    function () {
        Route::post('login', [AuthController::class, 'login']);


        Route::middleware('auth:api')->group(
            function () {
                Route::post('/register', [AuthController::class, 'register']);
                Route::get('/user', [UserController::class, 'getUser']);
                Route::post('/logout', [UserController::class, 'logout']);
                Route::apiResource('daily-updates', DailyUpdateController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
                Route::apiResource('organizations', OrganizationController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
            }
        );
    }
);
