<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use Faker\Factory as Faker;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        foreach (range(1, 10) as $i) {
            Cliente::create([
                'nome' => $faker->name,
                'cpf_cnpj' => $faker->cpf(false),
                'endereco' => $faker->address,
                'telefone' => $faker->phoneNumber,
            ]);
        }
    }
}
