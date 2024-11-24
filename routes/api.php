<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('users', UserApiController::class, ['as' => 'api']);
});


Route::controller(AuthApiController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get('user', 'getUser')->middleware('auth:sanctum');
    Route::delete('logout', 'logout')->middleware('auth:sanctum');
});
