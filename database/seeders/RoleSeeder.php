<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()->create(['nome' => 'Administrador']);
        Role::factory()->create(['nome' => 'Diretor']);
        Role::factory()->create(['nome' => 'Coordenador']);
        Role::factory()->create(['nome' => 'Servidor']);
    }
}
