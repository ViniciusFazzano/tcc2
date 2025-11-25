<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemPedidoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'pedido_id' => Pedido::factory(),
            'produto_id' => Produto::factory(),
            'quantidade' => $this->faker->numberBetween(1, 10),
            'preco_unitario' => $this->faker->randomFloat(2, 10, 200),
        ];
    }
}
