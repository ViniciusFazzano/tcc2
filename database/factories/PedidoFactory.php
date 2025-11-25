<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Fazenda;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    public function definition(): array
    {
        $cliente = Cliente::factory()->create();
        $fazenda = Fazenda::factory()->create([
            'cliente_id' => $cliente->id
        ]);

        return [
            'cliente_id' => $cliente->id,
            'fazenda_id' => $fazenda->id,
            'data' => now()->toDateString(),
            'valor_total' => $this->faker->randomFloat(2, 100, 1000),
            'observacoes' => $this->faker->sentence(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($pedido) {
            \App\Models\ItemPedido::factory()->count(2)->create([
                'pedido_id' => $pedido->id
            ]);
        });
    }

}
