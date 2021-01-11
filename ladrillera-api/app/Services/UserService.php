<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

use App\User;

class UserService
{

    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct()
    {
    }


    public function getAll()
    {
        return User::all();
    }

    public function createUser($name, $email, $normal_password)
    {
        $user = new User([
            'name'     => $name,
            'email'    => $email,
            'password' => bcrypt($normal_password),
        ]);
        $user->save();
        Log::info('A new user is being created');
        return $user;
    }

    public function updateUser($user, $name, $email, $normal_password)
    {

        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($normal_password);
        $user->save();
        Log::info('A user is being updated');
        return $user;
    }
}
