<?php

namespace Database\Factories;

use App\Models\{User, Subgrupo, Situacao, Origem, Sala, UnidadeAdministrativa};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PatrimonioFactory extends Factory
{
    public function definition()
    {
        static $userIds = null;
        static $subgrupoIds = null;
        static $situacaoIds = null;
        static $origemIds = null;
        static $salaIds = null;
        static $unidadeAdminIds = null;

        if (is_null($userIds)) {
            $userIds = User::pluck('id')->toArray();
            $subgrupoIds = Subgrupo::pluck('id')->toArray();
            $situacaoIds = Situacao::pluck('id')->toArray();
            $origemIds = Origem::pluck('id')->toArray();
            $salaIds = Sala::pluck('id')->toArray();
            $unidadeAdminIds = UnidadeAdministrativa::pluck('id')->toArray();
        }

        return [
            'nome' => $this->faker->streetName,
            'nota_fiscal' => Str::random(10),
            'descricao' => $this->faker->sentence,
            'data_compra' => $this->faker->date,
            'observacao' => $this->faker->text(),
            'valor' => $this->faker->numberBetween(100, 5000),
            'empenho' => $this->faker->sentence,
            'conta_contabil' => $this->faker->sentence,
            'user_id' => $this->faker->randomElement($userIds),
            'subgrupo_id' => $this->faker->randomElement($subgrupoIds),
            'situacao_id' => $this->faker->randomElement($situacaoIds),
            'origem_id' => $this->faker->randomElement($origemIds),
            'sala_id' => $this->faker->randomElement($salaIds),
            'unidade_admin_id' => $this->faker->randomElement($unidadeAdminIds),
        ];
    }
}
