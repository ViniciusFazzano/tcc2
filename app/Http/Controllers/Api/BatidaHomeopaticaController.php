<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBatidaHomeopaticaRequest;
use App\Models\BatidaHomeopatica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatidaHomeopaticaController extends Controller
{
    public function index()
    {
        $batidas = BatidaHomeopatica::with(['pedido', 'produto'])
            ->orderByDesc('id')
            ->paginate(10);

        return response()->json($batidas, 200);
    }

    public function store(StoreBatidaHomeopaticaRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();

            $exists = BatidaHomeopatica::where('pedido_id', $data['pedido_id'])
                ->where('produto_id', $data['produto_id'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'Já existe um cálculo para este produto neste pedido.'
                ], 409);
            }

            $batida = $this->calcularEBaixar($data);

            return response()->json([
                'message' => 'Cálculo criado com sucesso!',
                'data' => $batida
            ], 201);
        });
    }

    public function show($id)
    {
        $batida = BatidaHomeopatica::with(['pedido', 'produto'])->find($id);

        if (!$batida) {
            return response()->json(['message' => 'Batida não encontrada.'], 404);
        }

        return response()->json($batida, 200);
    }

    public function update(StoreBatidaHomeopaticaRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $batida = BatidaHomeopatica::find($id);

            if (!$batida) {
                return response()->json(['message' => 'Batida não encontrada.'], 404);
            }

            $data = $request->validated();
            $atualizada = $this->calcularEBaixar($data, $batida);

            return response()->json([
                'message' => 'Batida atualizada com sucesso!',
                'data' => $atualizada
            ], 200);
        });
    }

    public function destroy($id)
    {
        $batida = BatidaHomeopatica::find($id);

        if (!$batida) {
            return response()->json(['message' => 'Batida não encontrada.'], 404);
        }

        $batida->delete();

        return response()->json(['message' => 'Batida excluída com sucesso!'], 200);
    }

    /**
     * Função auxiliar para cálculo e persistência.
     */
    private function calcularEBaixar(array $data, ?BatidaHomeopatica $batida = null)
    {
        $pesoTotal = $data['qnt_saco'] * $data['kilo_saco'];
        $qntBatida = floor($pesoTotal / $data['kilo_batida']);
        $consumoCabecaKilo = $data['consumo_cabeca'] / 1000;
        $cabecaSaco = $data['kilo_saco'] / $consumoCabecaKilo;
        $gramasHomeopatiaSaco = $cabecaSaco * $data['grama_homeopatia_cabeca'];
        $kiloHomeopatiaBatida = (($gramasHomeopatiaSaco / 1000) * $data['qnt_saco']) / $qntBatida;
        $qntCaixa = (($gramasHomeopatiaSaco / 1000) * $data['qnt_saco']) / ($data['gramas_homeopatia_caixa'] / 1000);

        $dadosCalculo = [
            ...$data,
            'peso_total' => $pesoTotal,
            'qnt_batida' => $qntBatida,
            'consumo_cabeca_kilo' => $consumoCabecaKilo,
            'cabeca_saco' => $cabecaSaco,
            'gramas_homeopatia_saco' => $gramasHomeopatiaSaco,
            'kilo_homeopatia_batida' => $kiloHomeopatiaBatida,
            'qnt_caixa' => $qntCaixa,
        ];

        if ($batida) {
            $batida->update($dadosCalculo);
        } else {
            $batida = BatidaHomeopatica::create($dadosCalculo);
        }

        return $batida->fresh(['pedido', 'produto']);
    }
}
