<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class FazendaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(),
            'nome' => 'Fazenda ' . $this->faker->lastName(),
            'localizacao' => $this->faker->city(),
            'tamanho_hectares' => $this->faker->numberBetween(10, 500),
            'observacoes' => $this->faker->sentence(),
        ];
    }
}
