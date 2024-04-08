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
            $unid_adm = new UnidadeAdministrativa();
            $unid_adm->nome = $linha[0];
            $unid_adm->codigo = $linha[1];   
            $unid_adm->save();
        }
    }
}