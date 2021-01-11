<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\User;
use Illuminate\Support\Facades\Config;

class ProductoService
{

    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct()
    {
    }


    public function getAll()
    {
        return Config::get('constants.productos');
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
}
