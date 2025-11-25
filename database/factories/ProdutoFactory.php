<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => 'Produto ' . $this->faker->word(),
            'preco' => $this->faker->randomFloat(2, 1, 500),
            'estoque' => $this->faker->numberBetween(0, 200),
            'observacao' => $this->faker->sentence(),
            'ncm' => $this->faker->numerify('########'),
            'solucao' => $this->faker->word(),
        ];
    }
}
