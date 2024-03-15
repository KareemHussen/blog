<?php

namespace App\Services;

use App\Models\User;

class SocialiteService
{

    public function loginRegisterSocialiteUser($name , $email , $social_id , $social_type)
    {
        $user = User::firstOrCreate(['email' => $email], [
            'name' => $name,
            'social_id' => $social_id,
            'social_type' => $social_type,
        ]);
    
        if (!$user->social_id) {
            $user->update([
                'social_id' => $social_id,
                'social_type' => $social_type
            ]);
        }

        return $user;
    }
}
