<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\User;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class IaController extends Controller
{
    public function perguntar(Request $request, GeminiService $gemini)
    {
        $request->validate([
            'prompt' => ['required', 'string', 'max:8000'],
        ]);

        $produtos = Produto::select('nome', 'solucao')->get(); // Exemplo: pega o usuário com ID 1

        $produtosTexto = $produtos->map(function ($p) {
            return "Produto: {$p->nome} solucao para {$p->solucao}";
        })->implode("\n");

        $system = "Você é um vendedor especializado em homeopatia veterinária para gado de corte e leite.
                    Seu papel é apresentar os produtos pelo nome e explicar de forma clara, confiável e acessível o que cada um faz, sem mencionar a marca que os fabrica.
                    Ao responder, siga estas regras:
                    Sempre explique para que serve o produto (ex.: controle de papilomatose, melhora da imunidade, tratamento de mastite, etc.).
                    Dê exemplos práticos de uso, como: 'Esse produto pode ser usado misturado no sal mineral' ou 'Indicado para animais que apresentam verrugas'.
                    Use uma linguagem próxima ao produtor rural, simples e sem termos técnicos complexos.
                    Não cite o nome da marca, apenas o nome do produto e sua finalidade.
                    Caso o cliente peça comparação, destaque os benefícios práticos: melhora na saúde, menos perdas, redução de antibióticos, aumento da produtividade.
                    Exemplos de produtos que você vai usar para responder as perguntas dos clientes:

                    $produtosTexto

                    Seu objetivo é orientar, informar e recomendar os produtos de acordo com a necessidade do cliente, responda de forma simples e mais ou menos direta.";

        $texto = $gemini->generate(
            prompt: $request->input('prompt'),
            system: $system,
            temperature: 0.5,
            maxOutputTokens: 1000
        );

        return response()->json([
            'model' => config('services.gemini.model'),
            'output' => $texto,
        ]);
    }
}
