<?php

use Illuminate\Database\Seeder;
use App\Models\Modulo;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            'Administracion', 'Usuarios', 'Noticias',
            'Clientes', 'Pedidos', 'Finanzas', 'Despacho'
        ];
        foreach ($modules as $module) {
            // Do a mass assignment
            Modulo::Create(['nombre' => $module]);
        }
    }
}
