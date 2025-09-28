<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ItemPedido;

class ItemPedidoController extends Controller
{
    public function index()
    {
        return ItemPedido::with(['pedido', 'produto'])->get();
    }

    public function store(Request $request)
    {
        $item = ItemPedido::create($request->all());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        return ItemPedido::with(['pedido', 'produto'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $item = ItemPedido::findOrFail($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        ItemPedido::destroy($id);
        return response()->json(null, 204);
    }


}
