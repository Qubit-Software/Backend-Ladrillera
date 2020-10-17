<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Usuario;
use App\Models\Empleado;

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
            $usuario = Usuario::create([
                'correo' => $user->email,
                'contraseña' => $password,
                'id_empleado' => null,
                'activo' => 1,
                'auth_user_id' => $user->id
            ]);
            $gender = $faker->randomElement(['Masculino', 'Femenino', 'Otro']);
            $empleado = Empleado::create([
                'nombre' => "Robinson",
                'apellido' => 'Munoz',
                'cedula_ciudadania' => $faker->numberBetween(10, 10000),
                'genero' =>  $gender,
                'fecha_nacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'rol' => "Administrador",
                'correo' => $usuario->correo,
                'foto' => $faker->image(),
            ]);
            $empleado->save();
            $usuario->id_empleado = $empleado->id;
            $usuario->save();
        }

        // fakeData($faker, $password);
    }

    private function fakeData($faker, $password)
    {
        // And now let's generate a few dozen users for our app:
        for ($i = 0; $i < 5; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => $password,
            ]);
            $user->save();
            $usuario = Usuario::create([
                'nombre' => $faker->name,
                'correo' => $user->email,
                'contraseña' => $password,
                'id_empleado' => null,
                'activo' => $faker->boolean,
                'auth_user_id' => $user->id
            ]);
            $usuario->save();
            $gender = $faker->randomElement(['Masculino', 'Femenino', 'Otro']);
            $empleado = Empleado::create([
                'nombre' => $usuario->nombre,
                'apellido' => $faker->lastName,
                'cedula_ciudadania' => $faker->numberBetween(10, 10000),
                'genero' =>  $gender,
                'fecha_nacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'rol' => $faker->jobTitle,
                'correo' => $usuario->correo,
                'foto' => $faker->image(),
            ]);
            $usuario->id_empleado = $empleado->id;
            $usuario->save();
            $empleado->save();
        }
    }
}
