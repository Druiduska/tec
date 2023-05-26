<?php

namespace App\Actions\Auth;

use App\Models\Auth\User;
use Illuminate\Support\Facades\Hash;

class AuthAction
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return mixed
     */
    public static function registration(string $name, string $email, string $password)
    {
        $user = new User();

        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make( $password );
        $user->save();

//        event( new Registered( $user ) );

        return $user->id;
    }

}