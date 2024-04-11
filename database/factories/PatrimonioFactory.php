<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patrimonio>
 */
class PatrimonioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->streetName,
            'descricao' => $this->faker->sentence,
            'data_compra' => $this->faker->date,
            'valor' => $this->faker->numberBetween($min = 100, $max = 5000),
            'empenho' => $this->faker->sentence,
            'conta_contabil' => $this->faker->sentence,
            'user_id' => 2,
            'subgrupo_id' => 1,
            'situacao_id' => 1,
            'origem_id' => 1,
            'sala_id' => 1,
            'unidade_admin_id' => 1
        ];
    }
}
