<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fazenda;
use App\Models\Cliente;
use Faker\Factory as Faker;

class FazendaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $clientes = Cliente::all();

        foreach ($clientes as $cliente) {
            foreach (range(1, 2) as $i) {
                Fazenda::create([
                    'cliente_id' => $cliente->id,
                    'nome' => $faker->company . ' Farm',
                    'localizacao' => $faker->city,
                    'tamanho_hectares' => $faker->numberBetween(50, 500),
                    'observacoes' => $faker->sentence,
                ]);
            }
        }
    }
}
