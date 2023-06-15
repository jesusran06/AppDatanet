<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdditionalService;
use Illuminate\Support\Facades\DB;

class AdditionaServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->where('email', 'admin@gmail.com')->delete();

        $services = [
            ['name'=> 'Confiración Router Datanet', 'description' => 'Confiración Router u otros equipos', 'price' => 5],
            ['name'=> 'Confiración Router Otro', 'description' => 'Confiración Router u otros equipos otra procedencia', 'price' => 7],
            ['name'=> 'Instalación de Cables adicionales', 'description' => '', 'price' => 7],
            ['name'=> 'Instalación de Estructuras', 'description' => '', 'price' => 7],
            
        ];

        foreach ($services as $service) {
            $serve = new AdditionalService();
            $serve->name = $service['name'];
            $serve->description = $service['description'];
            $serve->price = $service['price'];
            $serve->save();
        }
    }
}
