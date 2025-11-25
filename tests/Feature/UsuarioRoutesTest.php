<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;

class UsuarioRoutesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function deve_listar_usuarios()
    {
        User::factory()->count(3)->create();

        $this->getJson('/api/v1/usuarios')
            ->assertStatus(200)
            ->assertJsonStructure(['data', 'current_page']);
    }

    #[Test]
    public function deve_criar_usuario()
    {
        $dados = [
            'nome' => 'Vinícius',
            'email' => 'teste@teste.com',
            'senha' => '123456',
            'nivel_acesso' => 'admin',
            'ativo' => true
        ];

        $this->postJson('/api/v1/usuarios', $dados)
            ->assertStatus(201)
            ->assertJsonFragment(['nome' => 'Vinícius']);
    }

    #[Test]
    public function nao_deve_criar_usuario_invalido()
    {
        $dados = [
            'email' => 'email-invalido',
            'senha' => '',
        ];

        $this->postJson('/api/v1/usuarios', $dados)
            ->assertStatus(422);
    }

    #[Test]
    public function deve_retornar_404_usuario_nao_existe()
    {
        $this->getJson("/api/v1/usuarios/user_inexistente@x.com")
            ->assertStatus(404);
    }

    #[Test]
    public function deve_excluir_usuario()
    {
        $user = User::factory()->create();

        $this->deleteJson("/api/v1/usuarios/{$user->email}")
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Usuário removido com sucesso.']);
    }

    #[Test]
    public function deve_resetar_senha_com_token_valido()
    {
        $user = User::factory()->create();
        $token = 'abc123';

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $this->postJson('/api/redefinicaoSenha', [
            'email' => $user->email,
            'token' => $token,
            'password' => 'novaSenha123'
        ])
            ->assertStatus(200)
            ->assertJsonFragment(['email' => $user->email]);
    }

    #[Test]
    public function nao_deve_resetar_senha_com_token_invalido()
    {
        $user = User::factory()->create();

        $this->postJson('/api/redefinicaoSenha', [
            'email' => $user->email,
            'token' => 'token_errado',
            'password' => 'novaSenha123'
        ])
            ->assertStatus(400)
            ->assertJsonFragment(['message' => 'Token inválido ou expirado.']);
    }
}
