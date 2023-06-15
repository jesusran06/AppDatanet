<?php

namespace Database\Seeders;

use App\Models\ItemPrice;
use Illuminate\Database\Seeder;

class ItemPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name'=> 'Instalación', 'description' => '', 'price' => 10.00],
            ['name'=> 'ONU', 'description' => '', 'price' => 5.00],
            ['name'=> 'Router', 'description' => '', 'price' => 25.00],
            
        ];

        foreach ($items as $item) {
            $it = new ItemPrice();
            $it->name = $item['name'];
            $it->description = $item['description'];
            $it->price = $item['price'];
            
            $it->save();
        }
    }
}
