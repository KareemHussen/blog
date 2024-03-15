<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(RegisterUserRequest $request)
    {
        $user = User::create($request->validated());
        
        return $this->respondCreated($user, 'Registered successfully');

    }


    public function login(LoginUserRequest $request)
    {
        $fields = $request->validated();

        $user = User::where('email', $fields['email'])->first();

        if (! $user || ! Hash::check(request()->post('password'), $user->password)) {
            return $this->respondError('Bad credentials.');
        }

        $token = $user->createToken(env("SANCTUM_TOKEN"))->plainTextToken;

        $user->token = $token;

        return $this->respondOk([
            "user" => $user
        ] , 'Login successfully');

    }

    public function logout(Request $request){
        
        $request->user->currentAccessToken()->delete();
        return $this->respondNoContent();
    
    }

    public function logoutAllDevices(Request $request){
        
        $request->user->tokens()->delete();
        return $this->respondNoContent();

    }

}
    
