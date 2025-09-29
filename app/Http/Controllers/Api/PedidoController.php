<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        return Pedido::with(['cliente', 'fazenda', 'itens.produto'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fazenda_id' => 'required|exists:fazendas,id',
            'data' => 'required|date',
            'valor_total' => 'required|numeric|min:0',
            'observacoes' => 'nullable|string',
            'itens' => 'required|array|min:1',
            'itens.*.produto_id' => 'required|exists:produtos,id',
            'itens.*.quantidade' => 'required|integer|min:1',
            'itens.*.preco_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $pedido = Pedido::create([
                'cliente_id' => $validated['cliente_id'],
                'fazenda_id' => $validated['fazenda_id'],
                'data' => $validated['data'],
                'valor_total' => $validated['valor_total'],
                'observacoes' => $validated['observacoes'] ?? null,
            ]);

            foreach ($validated['itens'] as $item) {
                $pedido->itens()->create($item);
            }

            DB::commit();
            return response()->json($pedido->load('itens.produto'), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $pedido = Pedido::with(['cliente', 'fazenda', 'itens.produto'])->findOrFail($id);
        return response()->json($pedido);
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $validated = $request->validate([
            'cliente_id' => 'sometimes|exists:clientes,id',
            'fazenda_id' => 'sometimes|exists:fazendas,id',
            'data' => 'sometimes|date',
            'valor_total' => 'sometimes|numeric|min:0',
            'observacoes' => 'nullable|string',
            'itens' => 'sometimes|array|min:1',
            'itens.*.produto_id' => 'required_with:itens|exists:produtos,id',
            'itens.*.quantidade' => 'required_with:itens|integer|min:1',
            'itens.*.preco_unitario' => 'required_with:itens|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $pedido->update($validated);

            if (isset($validated['itens'])) {
                // Remove itens antigos
                $pedido->itens()->delete();
                // Adiciona novos
                foreach ($validated['itens'] as $item) {
                    $pedido->itens()->create($item);
                }
            }

            DB::commit();
            return response()->json($pedido->load('itens.produto'), 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();
        return response()->json(['message' => 'Pedido removido com sucesso'], 200);
    }
}
