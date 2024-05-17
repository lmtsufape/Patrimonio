<?php

namespace Database\Seeders;

use App\Models\Codigo;
use App\Models\Patrimonio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatrimonioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Patrimonio::factory(30)->create();
    }
}
