<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Validator;

class PedidoController extends Controller
{
    /**
     * GET /api/pedidos
     * Lista paginada com filtros simples.
     * Filtros suportados:
     *  - q: busca por nome, ncm, observacao
     *  - ncm: igualdade
     *  - preco_min, preco_max
     *  - estoque_min, estoque_max
     *  - order_by (id|nome|preco|estoque|created_at), order_dir (asc|desc)
     *  - per_page
     */
    public function index(Request $request)
    {
        $query = Pedido::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = $request->get('q');
                $q->where(function ($w) use ($term) {
                    $w->where('nome', 'ilike', "%{$term}%")
                        ->orWhere('ncm', 'ilike', "%{$term}%")
                        ->orWhere('observacao', 'ilike', "%{$term}%");
                });
            })
            ->when($request->filled('ncm'), fn($q) => $q->where('ncm', $request->ncm))
            ->when($request->filled('preco_min'), fn($q) => $q->where('preco', '>=', (float) $request->preco_min))
            ->when($request->filled('preco_max'), fn($q) => $q->where('preco', '<=', (float) $request->preco_max))
            ->when($request->filled('estoque_min'), fn($q) => $q->where('estoque', '>=', (int) $request->estoque_min))
            ->when($request->filled('estoque_max'), fn($q) => $q->where('estoque', '<=', (int) $request->estoque_max));

        $orderBy = in_array($request->get('order_by'), ['id', 'nome', 'preco', 'estoque', 'created_at'])
            ? $request->get('order_by') : 'id';
        $orderDir = $request->get('order_dir') === 'asc' ? 'asc' : 'desc';

        $perPage = (int) ($request->get('per_page', 15));

        $page = $query->orderBy($orderBy, $orderDir)->paginate($perPage);

        $page->getCollection()->transform(function ($p) {
            return [
                'id' => $p->id,
                'nome' => $p->nome,
                'preco' => (float) $p->preco,
                'estoque' => (int) $p->estoque,
                'ncm' => $p->ncm,
                'observacao' => $p->observacao,
                'data_criacao' => optional($p->created_at)->toISOString(),
            ];
        });

        return response()->json($page);
    }

    /**
     * POST /api/pedidos
     * Cria um pedido.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => ['required', 'string', 'max:150'],
            'preco' => ['required', 'numeric', 'min:0'],
            'estoque' => ['required', 'integer', 'min:0'],
            'observacao' => ['nullable', 'string', 'max:5000'],
            'ncm' => ['required', 'string', 'max:20'], // se quiser, troque por ['regex:/^\d{8}$/']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validacao nos dados enviados.',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        $pedido = new Pedido();
        $pedido->nome = $data['nome'];
        $pedido->preco = (float) $data['preco'];
        $pedido->estoque = (int) $data['estoque'];
        $pedido->observacao = $data['observacao'] ?? null;
        $pedido->ncm = $data['ncm'];
        $pedido->save();

        return response()->json([
            'message' => 'Pedido criado com sucesso.',
            'data' => [
                'id' => $pedido->id,
                'nome' => $pedido->nome,
                'preco' => (float) $pedido->preco,
                'estoque' => (int) $pedido->estoque,
                'ncm' => $pedido->ncm,
                'observacao' => $pedido->observacao,
                'data_criacao' => optional($pedido->created_at)->toISOString(),
            ]
        ], 201);
    }

    /**
     * GET /api/pedidos/{pedido}
     * Mostra um pedido.
     */
    public function show(Pedido $pedido)
    {
        return response()->json([
            'id' => $pedido->id,
            'nome' => $pedido->nome,
            'preco' => (float) $pedido->preco,
            'estoque' => (int) $pedido->estoque,
            'ncm' => $pedido->ncm,
            'observacao' => $pedido->observacao,
            'data_criacao' => optional($pedido->created_at)->toISOString(),
        ]);
    }

    /**
     * PUT/PATCH /api/pedidos/{pedido}
     * Atualiza um pedido.
     */
    public function update(Request $request, Pedido $pedido)
    {
        $validator = Validator::make($request->all(), [
            'nome' => ['sometimes', 'required', 'string', 'max:150'],
            'preco' => ['sometimes', 'required', 'numeric', 'min:0'],
            'estoque' => ['sometimes', 'required', 'integer', 'min:0'],
            'observacao' => ['nullable', 'string', 'max:5000'],
            'ncm' => ['sometimes', 'required', 'string', 'max:20'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validacao nos dados enviados.',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if (array_key_exists('nome', $data))
            $pedido->nome = $data['nome'];
        if (array_key_exists('preco', $data))
            $pedido->preco = (float) $data['preco'];
        if (array_key_exists('estoque', $data))
            $pedido->estoque = (int) $data['estoque'];
        if (array_key_exists('observacao', $data))
            $pedido->observacao = $data['observacao'];
        if (array_key_exists('ncm', $data))
            $pedido->ncm = $data['ncm'];

        $pedido->save();

        return response()->json([
            'message' => 'Pedido atualizado com sucesso.',
            'data' => [
                'id' => $pedido->id,
                'nome' => $pedido->nome,
                'preco' => (float) $pedido->preco,
                'estoque' => (int) $pedido->estoque,
                'ncm' => $pedido->ncm,
                'observacao' => $pedido->observacao,
                'data_criacao' => optional($pedido->created_at)->toISOString(),
            ]
        ]);
    }

    /**
     * DELETE /api/pedidos/{pedido}
     * Remove um pedido.
     */
    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return response()->json([
            'message' => 'Pedido removido com sucesso.'
        ], 200);
    }
}
