<?php

namespace Database\Seeders;

use App\Models\Predio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PredioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $predios = [
            'Bloco de Sala de Aula A',
            'Bloco de Sala de Aula B',
            'Bloco de Sala de Aula C',
            'Bloco Administrativo',
            'Bloco de Professores I',
            'Blocos de Laboratórios I (LABENS)',
            'Blocos de Laboratórios II (CENLAG)',
            'Cantina Universitária', 'Bloco para Professores II',
            'Bloco de Laboratório III (Anatomia animal)',
            'Guarita', 'Hospital Veterinário',
            'Bloco de Laboratórios IV Eng Alim (LACTAL)',
            "Castelo d' água",
            'Casa dos Estudantes',
            'Quadra Poliesportiva',
            'Galpão I',
            'Galpão II',
            'Casa de Heliópolis'
        ];

        foreach($predios as $predio){
            Predio::factory()->create(['nome' => $predio]);
        }
    }
}
