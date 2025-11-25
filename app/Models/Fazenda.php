<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Fazenda extends Model
{
    use HasFactory;
    protected $fillable = ['cliente_id', 'nome', 'localizacao', 'tamanho_hectares', 'observacoes'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
