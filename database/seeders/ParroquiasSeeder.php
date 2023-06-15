<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Parroquia;

class ParroquiasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parroquias')->delete();
		$json = file_get_contents("database/data/parroquias.json");
	    $data = json_decode($json);
	    foreach ($data as $obj) {
	        Parroquia::create(array(
	            'id' => $obj->ID,
	            'id_municipio' => $obj->ID_MUNICIPIO,
	            'id_parroquia' => $obj->ID_PARROQUIA,
	            'parroquia' => $obj->PARROQUIA
	        ));
    	}
    }
}
