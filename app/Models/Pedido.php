<?php

use App\Models\Produto;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['data', 'cliente_id', 'total', 'empresa_batedora_id'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function empresaBatedora()
    {
        return $this->belongsTo(EmpresaBatedora::class);
    }

    // Pedido → muitos produtos através de ItemPedido
    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'itens_pedido')
            ->withPivot('quantidade', 'preco_unitario')
            ->withTimestamps();
    }

    public function itens()
    {
        return $this->hasMany(ItemPedido::class);
    }
}
