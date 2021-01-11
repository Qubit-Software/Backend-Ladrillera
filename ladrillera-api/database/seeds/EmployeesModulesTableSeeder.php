<?php

use Illuminate\Database\Seeder;
use App\Models\Empleado;
use App\Models\EmpleadoModel;
use App\Models\Modulo;
use App\Models\EmpleadoModulo as Empleado_Modulo;
use App\Models\EmpleadoModuloModel;
use App\Models\ModuloModel;

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
        $employee = EmpleadoModel::where('correo', '=', $adminEmail)->first();
        $adminModule = ModuloModel::where('nombre', 'like', '%' . $adminModuleName . '%')->first();
        $employeeModule = EmpleadoModuloModel::create([
            'id_empleado' => $employee->id,
            'id_modulo' => $adminModule->id
        ]);
        $employeeModule->save();
    }

    private function fakeData()
    {
        // Set other db stuff
        $employees = EmpleadoModel::all();
        $modules = ModuloModel::all();
    }
}
