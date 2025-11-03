<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatidaHomeopatica extends Model
{
    protected $fillable = [
        'pedido_id',
        'produto_id',
        'qnt_saco',
        'kilo_batida',
        'kilo_saco',
        'qnt_cabeca',
        'consumo_cabeca',
        'grama_homeopatia_cabeca',
        'gramas_homeopatia_caixa',
        'peso_total',
        'qnt_batida',
        'consumo_cabeca_kilo',
        'cabeca_saco',
        'gramas_homeopatia_saco',
        'kilo_homeopatia_batida',
        'qnt_caixa',
    ];

    public function pedido() {
        return $this->belongsTo(Pedido::class);
    }

    public function produto() {
        return $this->belongsTo(Produto::class);
    }
}
