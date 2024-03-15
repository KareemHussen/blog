<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialiteService;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{

    private SocialiteService $socialiteService;
    
    public function __construct()
    {
        $this->socialiteService = new SocialiteService();
    }


    public function loginWithProvider(string $platform)
    {
        return $this->respondOk([
            "url" => Socialite::driver($platform)->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    public function googleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $user = $this->socialiteService->loginRegisterSocialiteUser($user->name , $user->email , $user->id , "Google");

        $token = $user->createToken(env("SANCTUM_TOKEN"))->plainTextToken;

        $user->token = $token;
        
        return $this->respondOk([
            "user" => $user
        ] , 'Login successfully');

    }

    public function facebookCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();

        $user = $this->socialiteService->loginRegisterSocialiteUser($user->name , $user->email , $user->id , "Facebook");

        $token = $user->createToken(env("SANCTUM_TOKEN"))->plainTextToken;

        $user->token = $token;
        
        return $this->respondOk([
            "user" => $user
        ] , 'Login successfully');

    }
}
    
