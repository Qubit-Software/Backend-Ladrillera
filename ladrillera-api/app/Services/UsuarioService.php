<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;


use App\Models\UsuarioModel;
use App\User;
use Illuminate\Support\Facades\Log;

class UsuarioService
{

    protected $files_service;
    /**
     * Instantiate a new DocumentoController instance.
     */
    public function __construct(FilesService $files_service)
    {
        $this->files_service = $files_service;
    }


    public function createUsuario(User $user, $normal_password)
    {
        // Save to UsuarioModel table
        $usuario = new UsuarioModel([
            'correo' => $user->email,
            'contraseña' => bcrypt($normal_password),
            'auth_user_id' => $user->id,
        ]);

        Log::info('A new usuario is being created');
        $usuario->save();
        return $usuario;
    }

    public function updateUsuario(UsuarioModel $usuario, $data, $normal_password)
    {
        // Save to UsuarioModel table
        $usuario->correo = $data["email"];
        $usuario->contraseña = bcrypt($normal_password);
        $usuario->auth_user_id = $data["id"];

        Log::info('An usuario is being updated');
        $usuario->save();
        return $usuario;
    }
}
