<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GeminiService
{
    private string $apiKey;
    private string $model;
    private Client $http;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', env('GEMINI_API_KEY', ''));
        $this->model = config('services.gemini.model', env('GEMINI_MODEL', 'gemini-1.5-pro'));

        $this->http = new Client([
            'base_uri' => 'https://generativelanguage.googleapis.com/',
            'timeout' => 30,
            'verify' => false, // <- desativa a verificação do SSL
        ]);
    }

    /**
     * Gera texto com o Gemini a partir de um prompt.
     *
     * @param string      $prompt         Texto do usuário
     * @param string|null $system         Instrução de sistema (estilo/voz/regras do assistente)
     * @param float       $temperature    0.0 (determinístico) a ~1.0 (mais criativo)
     * @param int|null    $maxOutputTokens Limite de tokens de saída (opcional)
     * @return string                     Texto retornado pelo modelo
     *
     * @throws \RuntimeException
     */
    public function generate(
        string $prompt,
        ?string $system = null,
        float $temperature = 0.6,
        ?int $maxOutputTokens = null
    ): string {
        if (!$this->apiKey) {
            throw new \RuntimeException('GEMINI_API_KEY não configurada.');
        }

        $endpoint = sprintf('v1beta/models/%s:generateContent?key=%s', $this->model, $this->apiKey);

        // Monta o payload no formato da API do Gemini
        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => $temperature,
                'topP' => 0.95,
                'topK' => 40,
            ],
            // SafetySettings opcionais (padrões do Google já aplicam salvaguardas)
        ];

        if ($system) {
            // Instrução de sistema para orientar o tom e as regras do assistente
            $payload['systemInstruction'] = [
                'role' => 'system',
                'parts' => [
                    ['text' => $system],
                ],
            ];
        }

        if ($maxOutputTokens !== null) {
            $payload['generationConfig']['maxOutputTokens'] = $maxOutputTokens;
        }

        try {
            $res = $this->http->post($endpoint, [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => $payload,
                'verify' => false, // <- aqui também funciona
            ]);

        } catch (GuzzleException $e) {
            throw new \RuntimeException('Falha na chamada ao Gemini: ' . $e->getMessage(), 0, $e);
        }

        $body = json_decode((string) $res->getBody(), true);

        // Estrutura de resposta típica:
        // $body['candidates'][0]['content']['parts'] => array de partes (textos)
        $texto = $body['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$texto) {
            // Tente coletar mensagens de erro amigáveis
            $erro = $body['error']['message'] ?? 'Resposta inesperada do Gemini.';
            throw new \RuntimeException($erro);
        }

        return $texto;
    }
}
