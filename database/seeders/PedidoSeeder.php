<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Fazenda;
use App\Models\Produto;
use Faker\Factory as Faker;

class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $clientes = Cliente::all();
        $produtos = Produto::all();

        foreach ($clientes as $cliente) {
            $fazenda = $cliente->fazendas()->first();

            foreach (range(1, 3) as $i) {
                $pedido = Pedido::create([
                    'cliente_id' => $cliente->id,
                    'fazenda_id' => $fazenda->id,
                    'data' => $faker->dateTimeThisYear,
                    'valor_total' => 0, // vamos atualizar depois
                    'observacoes' => $faker->sentence,
                ]);

                $total = 0;
                foreach ($produtos->random(3) as $produto) {
                    $quantidade = $faker->numberBetween(1, 10);
                    $pedido->itens()->create([
                        'produto_id' => $produto->id,
                        'quantidade' => $quantidade,
                        'preco_unitario' => $produto->preco,
                    ]);
                    $total += $quantidade * $produto->preco;
                }

                $pedido->update(['valor_total' => $total]);
            }
        }
    }
}
