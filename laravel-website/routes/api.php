<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\MuseumApiController;

Route::middleware('api')->group(function () {
    Route::get('/museums/{page}', [MuseumApiController::class, 'catalog']);
    Route::get('/museum/{id}', [MuseumApiController::class, 'museum']);
    Route::get('/topic/{id}/{page}', [MuseumApiController::class, 'byTopics']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
