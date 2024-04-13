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
        User::factory()->create(['email' => 'admin@admin.com'])->roles()->attach(1);
        
        User::factory()->create(['email' => 'diretor@diretor.com'])->roles()->attach(2);

        User::factory()->create(['email' => 'coordenador@coordenador.com'])->roles()->attach(3);
        
        User::factory()->create(['email' => 'servidor@servidor.com'])->roles()->attach(4);
    }
}
