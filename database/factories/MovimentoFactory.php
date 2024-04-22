<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movimento>
 */
class MovimentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tipo' => \App\Models\Movimento::$tipos['solicitacao'],
            'servidor_id' => 2,
            'sala_id' => 1,
            'cargo_id' => 1
        ];
    }
}
