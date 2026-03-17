<?php

use App\Http\Controllers\api\ServerCheckController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/server-info', ServerCheckController::class)->middleware('auth:sanctum');