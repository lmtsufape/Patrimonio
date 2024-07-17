<?php

namespace Database\Seeders;

use App\Models\Servidor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1= User::factory()->create(['email' => 'admin@admin.com']);
        $user1->roles()->attach(1);
        $user1->cargos()->attach(2);
        $user1->salas()->attach(1);
        $user1->unidades()->attach(1);

        $user2=User::factory()->create(['email' => 'diretor@diretor.com']);
        $user2->roles()->attach(1);
        $user2->cargos()->attach(3);
        $user2->salas()->attach(1);
        $user2->unidades()->attach(1);

        $user3=User::factory()->create(['email' => 'coordenador@coordenador.com']);
        $user3->roles()->attach(2);
        $user3->cargos()->attach(3);
        $user3->salas()->attach(1);
        $user3->unidades()->attach(1);

        $user4=User::factory()->create(['email' => 'servidor@servidor.com']);
        $user4->roles()->attach(2);
        $user4->cargos()->attach(1);
        $user4->salas()->attach(1);
        $user4->unidades()->attach(1);

    }
}
