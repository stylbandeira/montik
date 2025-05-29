<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $produtos = Produto::with('variacoesDisponiveis')
            ->with('estoque.produto_variacoes.opcoes.variacao')
            ->withSum('estoque', 'quantidade')->get();

        return response([
            'produtos' => $produtos
        ]);
    }

    public function list()
    {
        $produtos = Produto::with('variacoesDisponiveis')
            ->with('estoque.produto_variacoes.opcoes.variacao')
            ->withSum('estoque', 'quantidade')->get();

        return Inertia::render('Comprar', [
            'produtos' => $produtos
        ]);
    }

    public function variacoesDisponiveis()
    {
        $produtos = Produto::with([
            'estoque' => function ($q) {
                $q->where('quantidade', '>', 0)
                    ->with([
                        'produto_variacoes.opcoes.variacao'
                    ]);
            }
        ])->get();

        $resultado = [];

        foreach ($produtos as $produto) {
            $produtoFormatado = [
                'id_produto' => $produto->id,
                'nome_produto' => $produto->nome,
                'descricao_produto' => $produto->descricao,
                'quantidade_total' => $produto->estoque_sum_quantidade ?? 0,
                'valor_produto' => $produto->preco,
                'variacoes_disponiveis' => []
            ];

            foreach ($produto->estoque as $estoque) {
                foreach ($estoque->produto_variacoes->opcoes as $opcao) {
                    $nomeVariacao = $opcao->variacao->nome_variacao;

                    $produtoFormatado['variacoes_disponiveis'][$nomeVariacao][] = [
                        'id_opcao' => $opcao->id,
                        'id_variacao' => $opcao->id_variacao,
                        'id_produto_variacao' => $estoque->produto_variacoes->id,
                        'valor' => $opcao->valor,
                        'estoque_id' => $estoque->id,
                        'quantidade' => $estoque->quantidade,
                    ];
                }
            }

            // Remove duplicatas por id_opcao em cada variação
            foreach ($produtoFormatado['variacoes_disponiveis'] as $nome => $opcoes) {
                $produtoFormatado['variacoes_disponiveis'][$nome] = collect($opcoes)
                    ->unique('id_opcao')
                    ->values()
                    ->toArray();
            }

            $resultado[] = $produtoFormatado;
        }

        return response()->json($resultado);
    }


    /**
     * Show the form for creating a new resource.'
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produtos = Produto::withSum('estoque', 'quantidade')
            ->with([
                'variacoesProduto.opcoes',
                'variacoesProduto.estoque',
                'estoque.produto'
            ])
            ->get();

        return Inertia::render('Produtos', [
            'produtos' => $produtos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descricao' => 'string',
            'nome' => 'required|string',
            'preco' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response([
                'message' => 'Validação falhou',
                'errors' => $validator->errors()
            ]);
        }

        $produto = Produto::create($request->all());

        return response([
            'message' => 'Produto cadastrado com sucesso!',
            'produto' => $produto
        ]);
    }

    /**
     * Display an specific product
     *
     * @param Int $id
     * @return void
     */
    public function show(Int $id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response([
                'message' => 'Produto não encontrado'
            ], 404);
        }

        return response([
            'produto' => $produto
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Int $id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response([
                'message' => 'Produto não encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'descricao' => 'string|nullable',
            'nome' => 'string|nullable',
            'preco' => 'numeric|nullable'
        ]);

        if ($validator->fails()) {
            return response([
                'message' => 'Validação falhou',
                'errors' => $validator->errors()
            ]);
        }

        $dados = not_null($request->all());

        $produto->update($dados);

        return response([
            'message' => 'Produto alterado com sucesso!',
            'produto' => $produto
        ]);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param Int $id
     * @return void
     */
    public function destroy(Int $id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response([
                'message' => 'Produto não encontrado'
            ], 404);
        }

        $produto->delete();

        return response([
            'message' => 'Produto deletado com sucesso!',
            'produto' => $produto
        ]);
    }
}
