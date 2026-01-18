<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\MuseumApiController;

Route::middleware('api')->group(function () {
    Route::get('/museums/{page}', [MuseumApiController::class, 'catalog']);
    Route::get('/museum/{id}', [MuseumApiController::class, 'museum']);
    Route::get('/topics/{id}/{page}', [MuseumApiController::class, 'museumTopics']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
