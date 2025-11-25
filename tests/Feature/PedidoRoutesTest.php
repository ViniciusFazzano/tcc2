<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Fazenda;
use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class PedidoRoutesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function deve_listar_pedidos()
    {
        Pedido::factory()
            ->hasItens(2)
            ->create();

        $this->getJson('/api/v1/pedidos')
            ->assertStatus(200)
            ->assertJsonCount(1);
    }

    #[Test]
    public function deve_criar_pedido_com_itens()
    {
        $cliente = Cliente::factory()->create();
        $fazenda = Fazenda::factory()->create();

        $p1 = Produto::factory()->create();
        $p2 = Produto::factory()->create();

        $dados = [
            'cliente_id' => $cliente->id,
            'fazenda_id' => $fazenda->id,
            'data' => now()->toDateString(),
            'valor_total' => 300,
            'observacoes' => 'Urgente',

            'itens' => [
                [
                    'produto_id' => $p1->id,
                    'quantidade' => 2,
                    'preco_unitario' => 50
                ],
                [
                    'produto_id' => $p2->id,
                    'quantidade' => 1,
                    'preco_unitario' => 200
                ]
            ]
        ];

        $this->postJson('/api/v1/pedidos', $dados)
            ->assertStatus(201)
            ->assertJsonFragment(['valor_total' => 300])
            ->assertJsonFragment(['produto_id' => $p1->id])
            ->assertJsonFragment(['produto_id' => $p2->id]);

        $this->assertDatabaseHas('pedidos', [
            'cliente_id' => $cliente->id
        ]);

        $this->assertDatabaseHas('item_pedidos', [
            'produto_id' => $p1->id
        ]);
    }

    #[Test]
    public function nao_deve_criar_pedido_invalido()
    {
        $this->postJson('/api/v1/pedidos', [])
            ->assertStatus(422);
    }

    #[Test]
    public function deve_mostrar_pedido_com_itens_e_produtos()
    {
        $pedido = Pedido::factory()->create();
        $produto = Produto::factory()->create();

        $pedido->itens()->create([
            'produto_id' => $produto->id,
            'quantidade' => 3,
            'preco_unitario' => 20
        ]);

        $this->getJson("/api/v1/pedidos/{$pedido->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['produto_id' => $produto->id])
            ->assertJsonFragment(['quantidade' => 3]);
    }

    #[Test]
    public function deve_retornar_404_quando_pedido_nao_existe()
    {
        $this->getJson('/api/v1/pedidos/999999')
            ->assertStatus(404);
    }

    #[Test]
    public function deve_atualizar_pedido_e_itens()
    {
        $pedido = Pedido::factory()->create();
        $produto = Produto::factory()->create();

        $dados = [
            'valor_total' => 500,
            'itens' => [
                [
                    'produto_id' => $produto->id,
                    'quantidade' => 5,
                    'preco_unitario' => 100
                ]
            ]
        ];

        $this->putJson("/api/v1/pedidos/{$pedido->id}", $dados)
            ->assertStatus(200)
            ->assertJsonFragment(['valor_total' => 500])
            ->assertJsonFragment(['quantidade' => 5]);

        $this->assertDatabaseHas('item_pedidos', [
            'produto_id' => $produto->id,
            'quantidade' => 5
        ]);
    }

    #[Test]
    public function deve_excluir_pedido()
    {
        $pedido = Pedido::factory()->create();

        $this->deleteJson("/api/v1/pedidos/{$pedido->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Pedido removido com sucesso']);

        $this->assertDatabaseMissing('pedidos', [
            'id' => $pedido->id
        ]);
    }
}
