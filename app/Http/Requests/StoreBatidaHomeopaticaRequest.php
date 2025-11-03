<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBatidaHomeopaticaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'pedido_id' => 'required|exists:pedidos,id',
            'produto_id' => 'required|exists:produtos,id',
            'qnt_saco' => 'required|numeric|min:1',
            'kilo_batida' => 'required|numeric|min:0.1',
            'kilo_saco' => 'required|numeric|min:0.1',
            'qnt_cabeca' => 'required|numeric|min:1',
            'consumo_cabeca' => 'required|numeric|min:0.1',
            'grama_homeopatia_cabeca' => 'required|numeric|min:0.01',
            'gramas_homeopatia_caixa' => 'required|numeric|min:0.01',
        ];
    }
}
