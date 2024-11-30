<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Str;



class AuthController extends Controller
{
    public function register(Request $request){

        $fields = $request->all();

        $errors  = Validator::make($fields,[
            'email' => 'required|email',
            'password' => 'required|min:6|max:8'
        ]);

        if($errors->fails())
        {
            return response($errors->errors()->all(), 422);
        }

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'isValidEmail' => user::IS_INVALID_EMAIL,
            'remember_token' => Str::random(10).time()
        ]);

        return response(
            [
                'message' => 'user created'
            ],200);        
    }
}
