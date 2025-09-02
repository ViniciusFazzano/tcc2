<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Validator;

class ForgotPasswordController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Verifica se o usuário existe
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Email não encontrado no sistema.'
            ], 404);
        }

        // Gera token único
        $token = Str::random(60);

        // Apaga tokens antigos e salva novo
        DB::table('password_resets')->where('email', $request->email)->delete();

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Envia email
        Mail::send('emails.reset_password', ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Recuperação de Senha');
        });

        return response()->json([
            'message' => 'Link de recuperação enviado para o e-mail informado.',
            'token' => $token // 🔴 Em produção você NÃO retorna o token aqui, só por debug
        ], 200);
    }

    public function update(Request $request, User $user)
    {

        $validator = Validator::make($request->all(), [
            'senha' => ['sometimes', 'required', 'string', 'min:6', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validacao nos dados enviados.',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if (array_key_exists('senha', $data))
            $user->senha = Hash::make($data['senha']);
        if (array_key_exists('password', $data))
            $user->password = Hash::make($data['senha']);

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
}
