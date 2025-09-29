<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Fazenda extends Model
{
    protected $fillable = ['cliente_id', 'nome', 'localizacao', 'tamanho_hectares', 'observacoes'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
