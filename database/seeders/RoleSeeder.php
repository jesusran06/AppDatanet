<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['name'=> 'Admin', 'description' => 'Administrador del Sistema'],
            ['name'=> 'Vendedor', 'description' => 'Vendedor'],
            ['name'=> 'Gerente de Ventas', 'description' => 'Gerente de Ventas'],
            ['name'=> 'Gerente de Informatica', 'description' => 'Gerente de Informatica'],
            ['name'=> 'Tecnico Instalador', 'description' => 'Tecnico Instalador'],
        ];
        
        foreach ($status as $statu) {
            $st = new Role();
            $st->name = $statu['name'];
            $st->description = $statu['description'];
            $st->save();
        }
    }
}
