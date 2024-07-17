<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            CargoSeeder::class,
            PredioSeeder::class,
            UnidadeAdministrativaSeeder::class,
            SalaSeeder::class,
            UserSeeder::class,
            OrigemSeeder::class,
            ClassificacaoSeeder::class,
            SituacaoSeeder::class,
            SubgrupoSeeder::class,
            PatrimonioSeeder::class
        ]);
    }
}
