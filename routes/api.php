<?php

use App\Http\Controllers\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/webhook', [TelegramController::class, 'webhook']);
Route::post('/webhook-test', [TelegramController::class, 'webhookTest']);
