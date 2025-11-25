<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmpresaBatedoraFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => 'Homeopec ' . $this->faker->word(),
            'cnpj' => $this->faker->numerify('##############'),
            'responsavel' => $this->faker->name(),
            'telefone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
        ];
    }
}
