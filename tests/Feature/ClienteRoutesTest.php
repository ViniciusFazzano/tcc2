<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Fazenda;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ClienteRoutesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function deve_listar_clientes()
    {
        Cliente::factory()->count(3)->create();

        $this->getJson('/api/v1/clientes')
            ->assertStatus(200)
            ->assertJsonCount(3);
    }

    #[Test]
    public function deve_criar_cliente_sem_fazendas()
    {
        $dados = [
            'nome' => 'Cliente Teste',
            'cpf_cnpj' => '12345678901',
            'endereco' => 'Rua A, 123',
            'telefone' => '67999990000'
        ];

        $this->postJson('/api/v1/clientes', $dados)
            ->assertStatus(201)
            ->assertJsonFragment(['nome' => 'Cliente Teste']);
    }

    #[Test]
    public function deve_criar_cliente_com_fazendas()
    {
        $dados = [
            'nome' => 'Cliente Teste',
            'cpf_cnpj' => '12345678901',
            'endereco' => 'Rua A, 123',
            'telefone' => '67999990000',
            'fazendas' => [
                [
                    'nome' => 'Fazenda Boa Esperança',
                    'localizacao' => 'Dourados - MS',
                    'tamanho_hectares' => 150,
                    'observacoes' => 'Área fértil'
                ]
            ]
        ];

        $res = $this->postJson('/api/v1/clientes', $dados)
            ->assertStatus(201)
            ->assertJsonFragment(['nome' => 'Fazenda Boa Esperança']);

        $this->assertDatabaseHas('fazendas', [
            'nome' => 'Fazenda Boa Esperança'
        ]);
    }

    #[Test]
    public function deve_mostrar_cliente()
    {
        $cliente = Cliente::factory()->create();

        $this->getJson("/api/v1/clientes/{$cliente->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $cliente->id]);
    }

    #[Test]
    public function deve_retornar_404_cliente_nao_existe()
    {
        $this->getJson('/api/v1/clientes/999999')
            ->assertStatus(404);
    }

    #[Test]
    public function deve_atualizar_cliente()
    {
        $cliente = Cliente::factory()->create();

        $this->putJson("/api/v1/clientes/{$cliente->id}", [
            'nome' => 'Cliente Atualizado'
        ])
            ->assertStatus(200)
            ->assertJsonFragment(['nome' => 'Cliente Atualizado']);
    }

    #[Test]
    public function deve_excluir_cliente()
    {
        $cliente = Cliente::factory()->create();

        $this->deleteJson("/api/v1/clientes/{$cliente->id}")
            ->assertStatus(204);

        $this->assertDatabaseMissing('clientes', [
            'id' => $cliente->id
        ]);
    }
}
