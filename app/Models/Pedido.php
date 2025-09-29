<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'data',
        'cliente_id',
        'fazenda_id',
        'empresa_batedora_id',
        'valor_total',
        'observacoes'
    ];

    // Pedido → Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Pedido → Fazenda
    public function fazenda()
    {
        return $this->belongsTo(Fazenda::class);
    }

    // Pedido → Empresa Batedora
    public function empresaBatedora()
    {
        return $this->belongsTo(EmpresaBatedora::class);
    }

    // Pedido → muitos itens
    public function itens()
    {
        return $this->hasMany(ItemPedido::class);
    }

    // Pedido → muitos produtos através de ItemPedido (pivot)
    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'itens_pedido')
            ->withPivot('quantidade', 'preco_unitario')
            ->withTimestamps();
    }
}
