<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->company(),
            'cpf_cnpj' => $this->faker->numerify('##############'),
            'endereco' => $this->faker->streetAddress(),
            'telefone' => $this->faker->phoneNumber(),
        ];
    }
}
