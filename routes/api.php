<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request){
    return $request->user();
})->middleware('auth');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/token', function(){

    $str = bin2hex(random_bytes(32));

    dd(bcrypt($str));
});

