<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Fazenda;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class FazendaRoutesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function deve_listar_fazendas()
    {
        Fazenda::factory()->count(3)->create();

        $this->getJson('/api/v1/fazendas')
            ->assertStatus(200)
            ->assertJsonCount(3);
    }

    #[Test]
    public function deve_criar_fazenda()
    {
        $cliente = Cliente::factory()->create();

        $dados = [
            'cliente_id' => $cliente->id,
            'nome' => 'Fazenda Nova',
            'localizacao' => 'Dourados - MS',
            'tamanho_hectares' => 150,
            'observacoes' => 'Área muito produtiva',
        ];

        $this->postJson('/api/v1/fazendas', $dados)
            ->assertStatus(201)
            ->assertJsonFragment(['nome' => 'Fazenda Nova']);
    }

    #[Test]
    public function deve_mostrar_fazenda()
    {
        $fazenda = Fazenda::factory()->create();

        $this->getJson("/api/v1/fazendas/{$fazenda->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $fazenda->id]);
    }

    #[Test]
    public function deve_retornar_404_para_fazenda_inexistente()
    {
        $this->getJson('/api/v1/fazendas/999999')
            ->assertStatus(404);
    }

    #[Test]
    public function deve_atualizar_fazenda()
    {
        $fazenda = Fazenda::factory()->create();

        $this->putJson("/api/v1/fazendas/{$fazenda->id}", [
            'nome' => 'Fazenda Atualizada',
            'tamanho_hectares' => 400
        ])
            ->assertStatus(200)
            ->assertJsonFragment(['nome' => 'Fazenda Atualizada']);
    }

    #[Test]
    public function deve_excluir_fazenda()
    {
        $fazenda = Fazenda::factory()->create();

        $this->deleteJson("/api/v1/fazendas/{$fazenda->id}")
            ->assertStatus(204);
    }
}
