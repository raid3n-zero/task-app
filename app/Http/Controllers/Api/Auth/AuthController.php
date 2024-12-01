<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\newUserCreated;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Str;



class AuthController extends Controller
{

    public $secrectKey = '$2y$12$yQ13oztyB9ZD2xWR/D/oFuR4pM/aUWETLumguYl0xX0I1bpPTUUrm';

    public function register(Request $request){

        $fields = $request->all();

        $errors  = Validator::make($fields,[
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:8'
        ]);

        if($errors->fails())
        {
            return response($errors->errors()->all(), 422);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'isValidEmail' => user::IS_INVALID_EMAIL,
            'remember_token' => Str::random(10).time()
        ]);

        newUserCreated::dispatch($user);

        return response(
            [
                'user' => $user,
                'message' => 'user created'
            ],200);        
    }

    public function login(Request $request)
    {
        $fields = $request->all();
        
        $errors = Validator::make($fields, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if($errors->fails()){
            return response($errors->errors()->all());
        }

        $user = User::query()->where('email', $request->email)->first();

        if(!is_null($user))
        {
            if(intval($user->isValidEmail) !== User::IS_VALID_EMAIL)
            {
                return response(['message' => 'We send you an email verfication!check mail..']);
            }
        }

        if(!$user || !Hash::check($request->password, $user->password))
        {
            return response(['message' => 'invalid email or password!'], 422);
        }

        $token = $user->createToken($this->secrectKey)->plainTextToken;

        return response([
            'user' => $user,
            'message'=> 'loggedIn',
            'token' => $token,
            'isLoggedIn' => true
        ], 200);
    }

    public function validEmail($token)
    {
        User::where('remember_token', $token)->update([
            'isValidEmail' => User::IS_VALID_EMAIL
        ]);

        return redirect('/login');
    }
}
