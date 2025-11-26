<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('authors', App\Http\Controllers\AuthorController::class);
Route::apiResource('books', App\Http\Controllers\BookController::class);
