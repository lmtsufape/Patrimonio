<?php

namespace Database\Seeders;

use App\Models\UnidadeAdministrativa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnidadeAdministrativaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arquivo_csv = database_path('seeders/UnidadesAdministrativas.csv'); // caminho do arquivo CSV
        $dados_csv = array_map(function($linha) {
            return explode('#', $linha);
        }, file($arquivo_csv)); // lê o arquivo CSV

        foreach ($dados_csv as $linha) {
            
            if(trim($linha[2]) == 'null'){
                UnidadeAdministrativa::create([
                    'nome' => $linha[0],
                    'codigo' => $linha[1],
                    'unidade_admin_folha' => false,
                    'predio_id' => 1,

                ]);
            }else{
                UnidadeAdministrativa::create([
                    'nome' => $linha[0],
                    'codigo' => $linha[1],
                    'unidade_admin_pai_id' => intval(trim($linha[2])),
                    'predio_id' => 1,


                ]);
            }
            
        }
    }
}