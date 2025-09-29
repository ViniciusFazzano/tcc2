<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'preco',
        'estoque',
        'observacao',
        'ncm',
    ];

    protected $casts = [
        // 'decimal:2' retorna string; preferimos float para o JSON final
        'preco' => 'float',
        'estoque' => 'integer',
    ];

    // protected $fillable = ['nome', 'preco', 'estoque', 'ncm', 'observacao'];

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'itens_pedido')
            ->withPivot('quantidade', 'preco_unitario')
            ->withTimestamps();
    }

    public function itens()
    {
        return $this->hasMany(ItemPedido::class);
    }


}
