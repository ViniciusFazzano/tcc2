<?php

use Illuminate\Database\Eloquent\Model;

class EmpresaBatedora extends Model
{
    protected $fillable = ['nome', 'cnpj', 'endereco', 'telefone', 'responsavel_tecnico', 'crq_responsavel', 'observacoes'];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
