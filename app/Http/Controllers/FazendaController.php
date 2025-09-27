<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Fazenda;
use Illuminate\Http\Request;

class FazendaController extends Controller
{

    public function index()
    {
        return Fazenda::with('cliente')->get();
    }

    public function store(Request $request)
    {
        $fazenda = Fazenda::create($request->all());
        return response()->json($fazenda, 201);
    }

    public function show($id)
    {
        return Fazenda::with('cliente')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $fazenda = Fazenda::findOrFail($id);
        $fazenda->update($request->all());
        return response()->json($fazenda, 200);
    }

    public function destroy($id)
    {
        Fazenda::destroy($id);
        return response()->json(null, 204);
    }

}
