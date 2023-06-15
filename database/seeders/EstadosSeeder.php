<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Estado;
use Illuminate\Support\Facades\DB;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('estados')->delete();
	    $json = file_get_contents("database/data/estados.json");
	    $data = json_decode($json);
	    foreach ($data as $obj) {
	        Estado::create(array(
	            'id' => $obj->ID,
	            'estado' => $obj->ESTADO
	        ));
    	}
    }
}
