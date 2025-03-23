<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AddMessageController;
use App\Http\Middleware\CorsMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::namespace("Api")->prefix('')->group(function () {
    Route::middleware('throttle:10,1')->group(function () {
        // Route::post('new_futures',         [AddMessageController::class,          'newFutures']);
        Route::post('send_msg',           [AddMessageController::class,          'setMsg']);
        // Route::get('upload_files',        [AddMessageController::class,          'uploadFiles']);
    });
});
