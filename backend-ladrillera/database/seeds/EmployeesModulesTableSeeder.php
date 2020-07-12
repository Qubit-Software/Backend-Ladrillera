<?php

use Illuminate\Database\Seeder;
use App\Models\Empleado;
use App\Models\Modulo;
use App\Models\Empleado_Modulo;

class EmployeesModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = Empleado::all();
        $modules = Modulo::all();
    }
}
