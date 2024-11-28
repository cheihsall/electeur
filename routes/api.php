<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\YoungController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(YoungController::class)->group(function(){
    Route::get('/youngs','index');
    Route::post('/young','store');
    Route::put('/young/{id}','index');
    Route::delete('/young/{id}','destroy');
});
