<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'cpf_cnpj', 'endereco', 'telefone'];

    public function fazendas()
    {
        return $this->hasMany(Fazenda::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}