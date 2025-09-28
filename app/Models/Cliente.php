<?php

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
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