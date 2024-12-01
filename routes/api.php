<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request){
    return $request->user();
})->middleware('auth');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// projects
Route::get('/projects', [ProjectController::class, 'index']);
Route::post('/projects', [ProjectController::class, 'store']);
Route::put('/projects', [ProjectController::class, 'update']);

Route::post('/projects/pinned', [ProjectController::class, 'pinnedProject']);



Route::get('/token', function(){

    $str = bin2hex(random_bytes(32));

    dd(bcrypt($str));
});

