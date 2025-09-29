<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return Cliente::with('fazendas')->get();
    }

    public function store(Request $request)
    {
        $cliente = Cliente::create($request->only(['nome', 'cpf_cnpj', 'endereco', 'telefone']));

        if ($request->has('fazendas')) {
            foreach ($request->fazendas as $fazenda) {
                $cliente->fazendas()->create($fazenda);
            }
        }

        return response()->json($cliente->load('fazendas'), 201);
    }

    public function show($id)
    {
        return Cliente::with('fazendas')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->only(['nome', 'cpf_cnpj', 'endereco', 'telefone']));
        return response()->json($cliente, 200);
    }

    public function destroy($id)
    {
        Cliente::destroy($id);
        return response()->json(null, 204);
    }
}
