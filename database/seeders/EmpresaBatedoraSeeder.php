<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmpresaBatedora;
use Faker\Factory as Faker;

class EmpresaBatedoraSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        foreach (range(1, 5) as $i) {
            EmpresaBatedora::create([
                'nome' => $faker->company,
                'cnpj' => $faker->cnpj(false),
                'endereco' => $faker->address,
                'telefone' => $faker->phoneNumber,
                'responsavel_tecnico' => $faker->name,
                'crq_responsavel' => $faker->numerify('CRQ####'),
                'observacoes' => $faker->sentence,
            ]);
        }
    }
}
