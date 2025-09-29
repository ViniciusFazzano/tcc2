<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;
use Validator;

class ProdutoController extends Controller
{
    /**
     * GET /api/produtos
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
        $query = Produto::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = $request->get('q');
                $q->where(function ($w) use ($term) {
                    $w->where('nome', 'ilike', "%{$term}%")
                        ->orWhere('ncm', 'ilike', "%{$term}%")
                        ->orWhere('observacao', 'ilike', "%{$term}%");
                });
            })
            ->when($request->filled('ncm'), fn($q) => $q->where('ncm', $request->ncm))
            ->when($request->filled('solucao'), fn($q) => $q->where('solucao', $request->solucao))
            ->when($request->filled('preco_min'), fn($q) => $q->where('preco', '>=', (float) $request->preco_min))
            ->when($request->filled('preco_max'), fn($q) => $q->where('preco', '<=', (float) $request->preco_max))
            ->when($request->filled('estoque_min'), fn($q) => $q->where('estoque', '>=', (int) $request->estoque_min))
            ->when($request->filled('estoque_max'), fn($q) => $q->where('estoque', '<=', (int) $request->estoque_max));

        $orderBy = in_array($request->get('order_by'), ['id', 'nome', 'preco', 'estoque', 'created_at'])
            ? $request->get('order_by') : 'id';
        $orderDir = $request->get('order_dir') === 'asc' ? 'asc' : 'desc';

        $perPage = (int) ($request->get('per_page', 50));

        $page = $query->orderBy($orderBy, $orderDir)->paginate($perPage);

        $page->getCollection()->transform(function ($p) {
            return [
                'id' => $p->id,
                'nome' => $p->nome,
                'preco' => (float) $p->preco,
                'estoque' => (int) $p->estoque,
                'ncm' => $p->ncm,
                'observacao' => $p->observacao,
                'solucao' => $p->solucao,
                'data_criacao' => optional($p->created_at)->toISOString(),
            ];
        });

        return response()->json($page);
    }

    /**
     * POST /api/produtos
     * Cria um produto.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => ['required', 'string', 'max:150'],
            'preco' => ['required', 'numeric', 'min:0'],
            'estoque' => ['required', 'integer', 'min:0'],
            'observacao' => ['nullable', 'string', 'max:5000'],
            'solucao' => ['nullable', 'string', 'max:150'],
            'ncm' => ['required', 'string', 'max:20'], // se quiser, troque por ['regex:/^\d{8}$/']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validacao nos dados enviados.',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        $produto = new Produto();
        $produto->nome = $data['nome'];
        $produto->preco = (float) $data['preco'];
        $produto->estoque = (int) $data['estoque'];
        $produto->observacao = $data['observacao'] ?? null;
        $produto->ncm = $data['ncm'];
        $produto->solucao = $data['solucao'];
        $produto->save();

        return response()->json([
            'message' => 'Produto criado com sucesso.',
            'data' => [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'preco' => (float) $produto->preco,
                'estoque' => (int) $produto->estoque,
                'ncm' => $produto->ncm,
                'solucao' => $produto->solucao,
                'observacao' => $produto->observacao,
                'data_criacao' => optional($produto->created_at)->toISOString(),
            ]
        ], 201);
    }

    /**
     * GET /api/produtos/{produto}
     * Mostra um produto.
     */
    public function show(Produto $produto)
    {
        return response()->json([
            'id' => $produto->id,
            'nome' => $produto->nome,
            'preco' => (float) $produto->preco,
            'estoque' => (int) $produto->estoque,
            'ncm' => $produto->ncm,
            'solucao' => $produto->solucao,
            'observacao' => $produto->observacao,
            'data_criacao' => optional($produto->created_at)->toISOString(),
        ]);
    }

    /**
     * PUT/PATCH /api/produtos/{produto}
     * Atualiza um produto.
     */
    public function update(Request $request, Produto $produto)
    {
        $validator = Validator::make($request->all(), [
            'nome' => ['sometimes', 'required', 'string', 'max:150'],
            'preco' => ['sometimes', 'required', 'numeric', 'min:0'],
            'estoque' => ['sometimes', 'required', 'integer', 'min:0'],
            'observacao' => ['nullable', 'string', 'max:5000'],
            'ncm' => ['sometimes', 'required', 'string', 'max:20'],
            'solucao' => ['sometimes', 'required', 'string', 'max:150'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validacao nos dados enviados.',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if (array_key_exists('nome', $data))
            $produto->nome = $data['nome'];
        if (array_key_exists('preco', $data))
            $produto->preco = (float) $data['preco'];
        if (array_key_exists('estoque', $data))
            $produto->estoque = (int) $data['estoque'];
        if (array_key_exists('observacao', $data))
            $produto->observacao = $data['observacao'];
        if (array_key_exists('ncm', $data))
            $produto->ncm = $data['ncm'];
        if (array_key_exists('solucao', $data))
            $produto->solucao = $data['solucao'];

        $produto->save();

        return response()->json([
            'message' => 'Produto atualizado com sucesso.',
            'data' => [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'preco' => (float) $produto->preco,
                'estoque' => (int) $produto->estoque,
                'ncm' => $produto->ncm,
                'solucao' => $produto->solucao,
                'observacao' => $produto->observacao, 
                'data_criacao' => optional($produto->created_at)->toISOString(),
            ]
        ]);
    }

    /**
     * DELETE /api/produtos/{produto}
     * Remove um produto.
     */
    public function destroy(Produto $produto)
    {
        $produto->delete();

        return response()->json([
            'message' => 'Produto removido com sucesso.'
        ], 200);
    }
}
