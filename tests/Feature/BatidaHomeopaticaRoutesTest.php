<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\BatidaHomeopatica;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class BatidaHomeopaticaRoutesTest extends TestCase
{
    use RefreshDatabase;

    private function payload($pedido, $produto)
    {
        return [
            'pedido_id' => $pedido->id,
            'produto_id' => $produto->id,
            'qnt_saco' => 10,
            'kilo_batida' => 25,
            'kilo_saco' => 30,
            'qnt_cabeca' => 100,
            'consumo_cabeca' => 2,
            'grama_homeopatia_cabeca' => 4,
            'gramas_homeopatia_caixa' => 500
        ];
    }

    #[Test]
    public function deve_listar_batidas()
    {
        BatidaHomeopatica::factory()->count(3)->create();

        $this->getJson('/api/v1/batidas')
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    #[Test]
    public function deve_criar_batida()
    {
        $pedido = Pedido::factory()->create();
        $produto = Produto::factory()->create();

        $dados = $this->payload($pedido, $produto);

        $this->postJson('/api/v1/batidas', $dados)
            ->assertStatus(201)
            ->assertJsonFragment(['message' => 'Cálculo criado com sucesso!']);

        $this->assertDatabaseHas('batida_homeopaticas', [
            'pedido_id' => $pedido->id,
            'produto_id' => $produto->id
        ]);
    }

    #[Test]
    public function nao_deve_criar_batida_duplicada_para_mesmo_produto_e_pedido()
    {
        $pedido = Pedido::factory()->create();
        $produto = Produto::factory()->create();

        BatidaHomeopatica::factory()->create([
            'pedido_id' => $pedido->id,
            'produto_id' => $produto->id
        ]);

        $dados = $this->payload($pedido, $produto);

        $this->postJson('/api/v1/batidas', $dados)
            ->assertStatus(409)
            ->assertJsonFragment([
                'message' => 'Já existe um cálculo para este produto neste pedido.'
            ]);
    }

    #[Test]
    public function deve_mostrar_batida()
    {
        $batida = BatidaHomeopatica::factory()->create();

        $this->getJson("/api/v1/batidas/{$batida->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $batida->id]);
    }

    #[Test]
    public function deve_retornar_404_batida_inexistente()
    {
        $this->getJson('/api/v1/batidas/999999')
            ->assertStatus(404);
    }

    #[Test]
    public function deve_atualizar_batida()
    {
        $batida = BatidaHomeopatica::factory()->create();

        $dados = [
            ...$this->payload($batida->pedido, $batida->produto),
            'qnt_saco' => 20
        ];

        $this->putJson("/api/v1/batidas/{$batida->id}", $dados)
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Batida atualizada com sucesso!']);

        $this->assertDatabaseHas('batida_homeopaticas', [
            'id' => $batida->id,
            'qnt_saco' => 20
        ]);
    }

    #[Test]
    public function deve_excluir_batida()
    {
        $batida = BatidaHomeopatica::factory()->create();

        $this->deleteJson("/api/v1/batidas/{$batida->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Batida excluída com sucesso!']);

        $this->assertDatabaseMissing('batida_homeopaticas', [
            'id' => $batida->id
        ]);
    }
}
