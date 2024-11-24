<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return response()->json(['status' => true, 'data' => $request->user(), 'message' => 'User versao 2']);
})->middleware('auth:sanctum');

