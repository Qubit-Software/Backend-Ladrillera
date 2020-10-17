<?php

use Illuminate\Database\Seeder;
use App\Models\Empleado;
use App\Models\Modulo;
use App\Models\EmpleadoModulo as Empleado_Modulo;


class EmployeesModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Find admin
        $adminEmail = 'robinsonmu@unisabana.edu.co';
        $adminModuleName = 'Administracion';
        $employee = Empleado::where('correo', '=', $adminEmail)->first();
        $adminModule = Modulo::where('nombre', 'like', '%' . $adminModuleName . '%')->first();
        $employeeModule = Empleado_Modulo::create([
            'id_empleado' => $employee->id,
            'id_modulo' => $adminModule->id
        ]);
        $employeeModule->save();
    }

    private function fakeData()
    {
        // Set other db stuff
        $employees = Empleado::all();
        $modules = Modulo::all();
    }
}
