<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Usuario;
use App\Models\Empleado;
use App\Models\EmpleadoModel;
use App\Models\UsuarioModel;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's clear the users table first

        // Usuario::truncate();
        // Empleado::truncate();
        // User::truncate();

        $faker = \Faker\Factory::create();

        // Let's make sure everyone has the same password and 
        // let's hash it before the loop, or else our seeder 
        // will be too slow.
        $email = "robinsonmu@unisabana.edu.co";
        $password = bcrypt("robin69");

        $user = User::where('email', '=', $email)->first();
        if (is_null($user)) {
            $user = User::create([
                'name' => 'Administrator',
                'email' => $email,
                'password' => $password,
            ]);
            $user->save();
        }

        $usuario = UsuarioModel::create([
            'correo' => $user->email,
            'contraseña' => $password,
            'activo' => 1,
            'auth_user_id' => $user->id
        ]);
        $usuario->save();

        $gender = $faker->randomElement(['Masculino', 'Femenino', 'Otro']);
        $empleado = EmpleadoModel::create([
            'nombre' => "Robinson",
            'apellido' => 'Munoz',
            'cedula_ciudadania' => $faker->numberBetween(10, 100),
            'genero' =>  $gender,
            'fecha_nacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'rol' => "Administrador",
            'correo' => $usuario->correo,
            'foto' => $faker->image(),
            'id_usuario' => $usuario->id
        ]);
        $empleado->save();
    }
}
