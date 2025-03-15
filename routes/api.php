<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ApiJobController;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\AuthController;


Route::post('/login', [AuthController::class, 'apiLogin']);

// Group routes with JWT authentication middleware
Route::middleware('auth:api')->prefix('v1')->group(function() {
    Route::apiResource('/jobs', ApiJobController::class);
});

// Add a route to get the authenticated user
Route::get('/user', function (Request $request) {
    return JWTAuth::parseToken()->authenticate();
});
