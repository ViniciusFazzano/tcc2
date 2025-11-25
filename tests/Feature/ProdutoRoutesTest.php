<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ProdutoRoutesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function deve_listar_produtos()
    {
        Produto::factory()->count(3)->create();

        $this->getJson('/api/v1/produtos')
            ->assertStatus(200)
            ->assertJsonStructure(['data', 'current_page']);
    }

    #[Test]
    public function deve_criar_produto()
    {
        $dados = [
            'nome' => 'Produto Teste',
            'preco' => 15.5,
            'estoque' => 10,
            'ncm' => '12345678',
            'solucao' => 'solucaoX',
            'observacao' => 'observacao teste'
        ];

        $this->postJson('/api/v1/produtos', $dados)
            ->assertStatus(201)
            ->assertJsonFragment(['nome' => 'Produto Teste']);
    }

    #[Test]
    public function nao_deve_criar_produto_invalido()
    {
        $dados = [
            'nome' => '',
            'preco' => -10,
            'estoque' => -5,
            'ncm' => '',
        ];

        $this->postJson('/api/v1/produtos', $dados)
            ->assertStatus(422);
    }

    #[Test]
    public function deve_mostrar_produto()
    {
        $produto = Produto::factory()->create();

        $this->getJson("/api/v1/produtos/{$produto->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $produto->id]);
    }

    #[Test]
    public function deve_retornar_404_se_produto_nao_existe()
    {
        $this->getJson("/api/v1/produtos/999999999")
            ->assertStatus(404);
    }

    #[Test]
    public function deve_atualizar_produto()
    {
        $produto = Produto::factory()->create();

        $this->putJson("/api/v1/produtos/{$produto->id}", [
            'nome' => 'Produto Atualizado',
            'preco' => 200,
        ])
            ->assertStatus(200)
            ->assertJsonFragment(['nome' => 'Produto Atualizado']);
    }

    #[Test]
    public function deve_validar_ao_atualizar_produto()
    {
        $produto = Produto::factory()->create();

        $this->putJson("/api/v1/produtos/{$produto->id}", [
            'preco' => -50
        ])
            ->assertStatus(422);
    }

    #[Test]
    public function deve_excluir_produto()
    {
        $produto = Produto::factory()->create();

        $this->deleteJson("/api/v1/produtos/{$produto->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Produto removido com sucesso.']);
    }
}
