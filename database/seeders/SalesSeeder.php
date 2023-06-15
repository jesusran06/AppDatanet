<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarios = [
            ['name' => 'MIGUEL DIAZ',    'role_id' => 2, 'password' => bcrypt('26945553'),    'email' => 'MIGUELDIAZ.MD.00@GMAIL.COM'],
            ['name' => 'ALBANY QUINTERO', 'role_id' => 2,    'password' => bcrypt('30145554'), 'email' => 'ALBANYQ14@GMAIL.COM'],
            ['name' => 'ALEJANDRO MICHELENA', 'role_id' => 2,    'password' => bcrypt('27868614'), 'email' => 'ALEJANDRO10MICHELENA@GMAIL.COM'],
            ['name' => 'ALEXIS PRADO', 'role_id' => 2,    'password' => bcrypt('11261918'), 'email' =>    'ALEXISJOSEPRADOROMERO@GMAIL.COM'],
            ['name' => 'BONNY GUAIDO', 'role_id' => 2,     'password' => bcrypt('17306051'), 'email' =>    'BONNY94321@GMAIL.COM'],
            ['name' => 'CHRISTOFER ORTIZ', 'role_id' => 2,    'password' => bcrypt('30894811'),    'email' =>    'CHRISTOFERORTIZ304@GMAIL.COM'],
            ['name' => 'EMELY AROCHA', 'role_id' => 2,    'password' => bcrypt('24163056'),    'email' => 'EMELYRALDIN16@GMAIL.COM'],
            ['name' => 'ENRIQUE BRICEÑO', 'role_id' => 2,    'password' => bcrypt('16387691'),    'email' => 'EBRICE2583@GMAIL.COM'],
            ['name' => 'ERICK SIVIRA', 'role_id' => 2,    'password' => bcrypt('14877080'),    'email' => 'ERICKSIVIRA@GMAIL.COM'],
            ['name' => 'GABRIELA SUAREZ', 'role_id' => 2,    'password' => bcrypt('30480385'),    'email' => 'GABRIELASUARE1@GMAIL.COM'],
            ['name' => 'GERSON MENDOZA', 'role_id' => 2,    'password' => bcrypt('12246676'),    'email' => 'MENDOZAGERZON4@GMAIL.COM'],
            ['name' => 'JOSE FREITEZ', 'role_id' => 2,    'password' => bcrypt('10504472'),    'email' => 'JEFREITEZ@GMAIL.COM'],
            ['name' => 'JOSE LEAL', 'role_id' => 2,    'password' => bcrypt('26120614'),    'email' => 'JOSEANTONIOLEALALVAREZ@GMAIL.COM'],
            ['name' => 'JULIO AGUIRRE', 'role_id' => 2,    'password' => bcrypt('16139109'),    'email' => 'JOTA.MARKETING2000@GMAIL.COM'],
            ['name' => 'KAREN MONTES', 'role_id' => 2,    'password' => bcrypt('20235751'),    'email' => 'KARENXAVIERMONTES@GMAIL.COM'],
            ['name' => 'LISNEYDI CHIRINOS', 'role_id' => 2,    'password' => bcrypt('15352269'),    'email' => 'LISNEYDI31@GMAIL.COM'],
            ['name' => 'LUIS DAVID ALVAREZ', 'role_id' => 2,    'password' => bcrypt('30480501'),    'email' => 'LUISDAVIDALVAREZ0226@GMAIL.COM'],
            ['name' => 'OSBLEIDA RODRIGUEZ', 'role_id' => 2,    'password' => bcrypt('13491623'),    'email' => 'OSBLEIDAR@GMAIL.COM'],
            ['name' => 'SAVIER VELASQUEZ', 'role_id' => 2,    'password' => bcrypt('17784438'),    'email' => 'SAVIER.VELAZQUEZ@GMAIL.COM'],
            ['name' => 'YOSCAR RODRIGUEZ', 'role_id' => 2,    'password' => bcrypt('18997386'), 'email' => 'ELRODRI2016Z@GMAIL.COM'],
            ['name' => 'JORDANA MUÑOZ', 'role_id' => 2,    'password' => bcrypt('16418326'), 'email' => 'JORDANAMO30@GMAIL.COM'],
            ['name' => 'JOSE BENITEZ', 'role_id' => 2,    'password' => bcrypt('13206445'), 'email' => 'JOSEBENITEZALVAREZ@GMAIL.COM'],
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
