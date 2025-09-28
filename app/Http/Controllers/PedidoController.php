<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Pedido;


class PedidoController extends Controller
{
    public function index()
    {
        return Pedido::with(['cliente', 'empresaBatedora'])->get();
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $pedido = Pedido::create($request->only(['data', 'cliente_id', 'empresa_batedora_id', 'total']));

            if ($request->has('produtos')) {
                foreach ($request->produtos as $produto) {
                    $pedido->produtos()->attach(
                        $produto['produto_id'],
                        [
                            'quantidade' => $produto['quantidade'],
                            'preco_unitario' => $produto['preco_unitario']
                        ]
                    );
                }
            }

            DB::commit();
            return response()->json($pedido->load('produtos'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        $pedido = Pedido::with(['cliente', 'empresaBatedora', 'produtos'])->findOrFail($id);
        return response()->json($pedido);
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->update($request->all());
        return response()->json($pedido, 200);
    }

    public function destroy($id)
    {
        Pedido::destroy($id);
        return response()->json(null, 204);
    }

}
