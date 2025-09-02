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

   
}
