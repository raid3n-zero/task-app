<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
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

    Route::get('/projects/{slug}', 'getProject');

}); 

// members
Route::controller(MemberController::class)->group(function(){
    Route::get('/members', 'index');
    Route::post('/members', 'store');
    Route::put('/members', 'update');
});

// task
Route::controller(TaskController::class)->group(function(){
    Route::post('/task', 'createTask');
});

Route::get('/token', function(){

    $str = bin2hex(random_bytes(32));

    dd(bcrypt($str));
});

