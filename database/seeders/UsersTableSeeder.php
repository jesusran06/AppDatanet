<?php


namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->where('email', 'admin@gmail.com')->delete();

        $usuarios = [
            ['name'=> 'John Doe', 'role_id' => 1, 'email' => 'admin@tms.com','password' => bcrypt('123456007')],
            ['name'=> 'Elver Galarga', 'role_id' => 2, 'email' => 'elver@tms.com','password' => bcrypt('123456007')],
            ['name'=> 'Alma Maria Rico', 'role_id' => 3, 'email' => 'alma@tms.com','password' => bcrypt('123456007')],
            
        ];

        foreach ($usuarios as $usuario) {
            $usu = new User();
            $usu->name = $usuario['name'];
            $usu->role_id = $usuario['role_id'];
            $usu->email = $usuario['email'];
            $usu->password = $usuario['password'];
            $usu->save();
        }
    }
}
