<?php

namespace Database\Factories;

use App\Models\BatidaHomeopatica;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class BatidaHomeopaticaFactory extends Factory
{
    protected $model = BatidaHomeopatica::class;

    public function definition(): array
    {
        return [
            'pedido_id' => Pedido::factory(),
            'produto_id' => Produto::factory(),

            'qnt_saco' => 10,
            'kilo_batida' => 25,
            'kilo_saco' => 30,
            'qnt_cabeca' => 100,
            'consumo_cabeca' => 2,
            'grama_homeopatia_cabeca' => 4,
            'gramas_homeopatia_caixa' => 500,

            // resultados
            'peso_total' => 300,
            'qnt_batida' => 12,
            'consumo_cabeca_kilo' => 0.002,
            'cabeca_saco' => 15000,
            'gramas_homeopatia_saco' => 60000,
            'kilo_homeopatia_batida' => 50,
            'qnt_caixa' => 120,
        ];
    }
}
