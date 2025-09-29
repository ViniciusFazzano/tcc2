<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaBatedora extends Model
{
    use HasFactory;

    protected $table = 'empresa_batedoras';

    protected $fillable = [
        'nome',
        'cnpj',
        'endereco',
        'telefone',
        'responsavel_tecnico',
        'crq_responsavel',
        'observacoes',
    ];
}
