<?php

namespace Database\Seeders;
use App\Models\TipoUsuario;
use Illuminate\Database\Seeder;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['nombre' => 'Super Administrador', 'estatus' => 'Activo'],
            ['nombre' => 'Administrador', 'estatus' => 'Activo'],
            ['nombre' => 'Lider', 'estatus' => 'Activo'],
        ];

        TipoUsuario::insert($data);
    }
}
