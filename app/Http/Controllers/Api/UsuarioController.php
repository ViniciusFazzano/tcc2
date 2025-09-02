<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Validator;

class UsuarioController extends Controller
{
    /**
     * GET /api/usuarios
     * Lista paginada (com filtros simples).
     */
    public function index(Request $request)
    {
        $query = User::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = $request->get('q');
                $q->where(function ($w) use ($term) {
                    $w->where('nome', 'ilike', "%{$term}%")
                        ->orWhere('email', 'ilike', "%{$term}%");
                });
            })
            ->when($request->filled('nivel_acesso'), fn($q) => $q->where('nivel_acesso', $request->nivel_acesso))
            ->when($request->filled('ativo'), fn($q) => $q->where('ativo', filter_var($request->ativo, FILTER_VALIDATE_BOOLEAN)));

        $perPage = (int) ($request->get('per_page', 15));

        $page = $query->orderByDesc('id')->paginate($perPage);

        // Mapeia data_criacao como created_at
        $page->getCollection()->transform(function ($u) {
            return [
                'id' => $u->id,
                'nome' => $u->nome,
                'email' => $u->email,
                'nivel_acesso' => $u->nivel_acesso,
                'ativo' => (bool) $u->ativo,
                'observacoes' => $u->observacoes,
                'data_criacao' => optional($u->created_at)->toISOString(),
            ];
        });

        return response()->json($page);
    }

    /**
     * POST /api/usuarios
     * Cria um usuário.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => ['sometimes', 'required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'senha' => ['sometimes', 'required', 'string', 'min:6', 'max:255'],
            'nivel_acesso' => ['sometimes', 'required', Rule::in(['admin', 'veterinario', 'cliente', 'operador'])],
            'ativo' => ['sometimes', 'boolean'],
            'observacoes' => ['nullable', 'string', 'max:5000'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validacao nos dados enviados.',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        $user = new User();
        $user->nome = $data['nome'];
        $user->name = $data['nome'];
        $user->email = $data['email'];
        $user->senha = Hash::make($data['senha']); // grava hash
        $user->password = Hash::make($data['senha']); // grava hash
        $user->nivel_acesso = $data['nivel_acesso'];
        $user->ativo = $data['ativo'] ?? true;
        $user->observacoes = $data['observacoes'] ?? null;
        $user->save();

        return response()->json([
            'message' => 'Usuário criado com sucesso.',
            'data' => [
                'id' => $user->id,
                'nome' => $user->nome,
                'name' => $user->nome,
                'email' => $user->email,
                'nivel_acesso' => $user->nivel_acesso,
                'ativo' => (bool) $user->ativo,
                'observacoes' => $user->observacoes,
                'data_criacao' => optional($user->created_at)->toISOString(),
            ]
        ], 201);
    }

    /**
     * GET /api/usuarios/{user}
     * Mostra um usuário.
     */
    public function show(User $user)
    {
        try {
            $usuario = User::findOrFail($user->id);

            return response()->json([
                'id' => $usuario->id,
                'nome' => $usuario->nome,
                'email' => $usuario->email,
                'nivel_acesso' => $usuario->nivel_acesso,
                'ativo' => (bool) $usuario->ativo,
                'observacoes' => $usuario->observacoes,
                'data_criacao' => optional($usuario->created_at)->toISOString(),
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Usuario nao encontrado.'
            ], 404);
        }
    }

    /**
     * PUT/PATCH /api/usuarios/{user}
     * Atualiza um usuário.
     */
    public function update(Request $request, User $user)
    {

        $validator = Validator::make($request->all(), [
            'nome' => ['sometimes', 'required', 'string', 'max:150'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'senha' => ['sometimes', 'required', 'string', 'min:6', 'max:255'],
            'nivel_acesso' => ['sometimes', 'required', Rule::in(['admin', 'veterinario', 'cliente', 'operador'])],
            'ativo' => ['sometimes', 'boolean'],
            'observacoes' => ['nullable', 'string', 'max:5000'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validacao nos dados enviados.',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if (array_key_exists('nome', $data))
            $user->nome = $data['nome'];
        if (array_key_exists('name', $data))
            $user->name = $data['nome'];
        if (array_key_exists('email', $data))
            $user->email = $data['email'];
        if (array_key_exists('senha', $data))
            $user->senha = Hash::make($data['senha']);
        if (array_key_exists('password', $data))
            $user->password = Hash::make($data['senha']);
        if (array_key_exists('nivel_acesso', $data))
            $user->nivel_acesso = $data['nivel_acesso'];
        if (array_key_exists('ativo', $data))
            $user->ativo = $data['ativo'];
        if (array_key_exists('observacoes', $data))
            $user->observacoes = $data['observacoes'];


        $user->save();

        return response()->json([
            'message' => 'Usuario atualizado com sucesso.',
            'data' => [
                'id' => $user->id,
                'nome' => $user->nome,
                'email' => $user->email,
                'nivel_acesso' => $user->nivel_acesso,
                'ativo' => (bool) $user->ativo,
                'observacoes' => $user->observacoes,
                'data_criacao' => optional($user->created_at)->toISOString(),
            ]
        ]);
    }

    /**
     * DELETE /api/usuarios/{user}
     * Remove um usuário.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'Usuário removido com sucesso.'
        ], 200);
    }


    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'], // usa password + password_confirmation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // Confere se existe token válido
        $reset = DB::table('password_resets')
            ->where('email', $data['email'])
            ->where('token', $data['token'])
            ->first();

        if (!$reset) {
            return response()->json([
                'message' => 'Token inválido ou expirado.'
            ], 400);
        }

        // (opcional) verificar expiração, ex: 60 min
        if (now()->diffInMinutes($reset->created_at) > 60) {
            return response()->json([
                'message' => 'Token expirado, solicite um novo link de recuperação.'
            ], 400);
        }

        // Atualiza senha
        $user = User::where('email', $data['email'])->firstOrFail();
        $user->password = Hash::make($data['password']);
        $user->senha = Hash::make($data['password']);
        $user->save();

        // Apaga token usado
        DB::table('password_resets')->where('email', $data['email'])->delete();

        return response()->json([
            'message' => 'Senha redefinida com sucesso.',
            'data' => [
                'id' => $user->id,
                'nome' => $user->nome,
                'email' => $user->email,
            ]
        ], 200);
    }
}
