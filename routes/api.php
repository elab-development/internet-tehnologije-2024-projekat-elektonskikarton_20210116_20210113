<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DoktorController;
use App\Http\Controllers\api\SestraController;
use App\Http\Controllers\api\TerapijaController;
use App\Http\Controllers\api\UstanovaController;
use App\Http\Controllers\api\DijagnozaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('dijagnoze', DijagnozaController::class);
Route::apiResource('doktori', DoktorController::class);
Route::apiResource('terapije', TerapijaController::class);
Route::apiResource('sestre', SestraController::class);
Route::apiResource('ustanove', UstanovaController::class);
