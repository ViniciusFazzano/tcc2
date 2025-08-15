<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;


class AuthController extends Controller
{

    // POST /login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'senha' => ['required', 'string', 'min:6'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['senha'], $user->senha)) {
            return response()->json([
                'message' => 'Credenciais invalidas.'
            ], 401);
        }

        if (isset($user->ativo) && !$user->ativo) {
            return response()->json([
                'message' => 'Usuario inativo.'
            ], 403);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Autenticado com sucesso.',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'nome' => $user->nome,
                'email' => $user->email,
                'nivel_acesso' => $user->nivel_acesso,
                'ativo' => (bool) $user->ativo,
                'observacoes' => $user->observacoes,
                'data_criacao' => optional($user->created_at)->toISOString(),
            ]
        ], 200);
    }

    // POST /logout (precisa estar autenticado)
    public function logout(Request $request)
    {
        // Apaga só o token atual:
        $request->user()->currentAccessToken()->delete();

        // // Se preferir: revoga TODOS os tokens do usuário
        // $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso.'
        ]);
    }

    // GET /me (rota de exemplo protegida)
    public function me(Request $request)
    {
        $u = $request->user();
        return response()->json([
            'id' => $u->id,
            'nome' => $u->nome,
            'email' => $u->email,
            'nivel_acesso' => $u->nivel_acesso,
            'ativo' => (bool) $u->ativo,
            'observacoes' => $u->observacoes,
            'data_criacao' => optional($u->created_at)->toISOString(),
        ]);
    }
}

