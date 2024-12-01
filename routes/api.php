<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request){
    return $request->user();
})->middleware('auth');


// auth
Route::controller(AuthController::class)->group( function (){

    Route::post('/register', 'register');
    Route::post('/login',  'login');
});

// projects
Route::controller(ProjectController::class)->group(function(){
    Route::get('/projects' , 'index');
    Route::post('/projects',  'store');
    Route::put('/projects', 'update');
    Route::post('/projects/pinned', 'pinnedProject');
});



Route::get('/token', function(){

    $str = bin2hex(random_bytes(32));

    dd(bcrypt($str));
});

