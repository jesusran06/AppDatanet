<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Municipio;
use Illuminate\Support\Facades\DB;

class MunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('municipios')->delete();
	    $json = $json = file_get_contents("database/data/municipios.json");
	    $data = json_decode($json);
	    foreach ($data as $obj) {
	        Municipio::create(array(
	            'id' => $obj->ID,
	            'id_estado' => $obj->ID_ESTADO,
	            'id_municipio' => $obj->ID_MUNICIPIO,
	            'municipio' => $obj->MUNICIPIO
	        ));
    	}
    }
}
