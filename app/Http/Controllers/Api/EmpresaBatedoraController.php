<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmpresaBatedora;
use Illuminate\Http\Request;

class EmpresaBatedoraController extends Controller
{
    /**
     * Lista todas as empresas batedoras.
     */
    public function index()
    {
        return response()->json(EmpresaBatedora::all(), 200);
    }

    /**
     * Cria uma nova empresa batedora.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:150',
            'cnpj' => 'required|string|max:20|unique:empresa_batedoras,cnpj',
            'endereco' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:30',
            'responsavel_tecnico' => 'nullable|string|max:150',
            'crq_responsavel' => 'nullable|string|max:50',
            'observacoes' => 'nullable|string',
        ]);

        $empresa = EmpresaBatedora::create($validated);

        return response()->json($empresa, 201);
    }

    /**
     * Mostra uma empresa batedora pelo ID.
     */
    public function show($id)
    {
        $empresa = EmpresaBatedora::findOrFail($id);
        return response()->json($empresa, 200);
    }

    /**
     * Atualiza os dados de uma empresa batedora.
     */
    public function update(Request $request, $id)
    {
        $empresa = EmpresaBatedora::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:150',
            'cnpj' => 'sometimes|required|string|max:20|unique:empresa_batedoras,cnpj,' . $empresa->id,
            'endereco' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:30',
            'responsavel_tecnico' => 'nullable|string|max:150',
            'crq_responsavel' => 'nullable|string|max:50',
            'observacoes' => 'nullable|string',
        ]);

        $empresa->update($validated);

        return response()->json($empresa, 200);
    }

    /**
     * Remove uma empresa batedora.
     */
    public function destroy($id)
    {
        $empresa = EmpresaBatedora::findOrFail($id);
        $empresa->delete();

        return response()->json(['message' => 'Empresa batedora removida com sucesso!'], 200);
    }
}
