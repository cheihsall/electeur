<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\YoungController;
use App\Http\Controllers\Api\RecenceController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(YoungController::class)->group(function(){
    Route::get('/youngs','index');
    Route::post('/young','store');
    Route::put('/young/{id}','index');
    Route::delete('/young/{id}','destroy');
});


Route::post('/register', [RecenceController::class, 'register']);
Route::post('/login', [RecenceController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [RecenceController::class, 'profile']);
    Route::post('/refresh', [RecenceController::class, 'refreshToken']);
    Route::post('/logout', [RecenceController::class, 'logout']);
});