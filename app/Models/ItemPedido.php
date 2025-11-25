<?php
namespace App\Models;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    use HasFactory;
    protected $table = 'item_pedidos';

    protected $fillable = [
        'pedido_id',
        'produto_id',
        'quantidade',
        'preco_unitario'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
