<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\OpcoesVariacoes;
use App\Models\Produto;
use App\Models\ProdutoVariacoes;
use App\Models\ProdutoVariacoesOpcoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class EstoqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $produtosEmEstoque = Estoque::with(['produto_variacoes', 'produto'])
            ->get();

        $array = [];

        foreach ($produtosEmEstoque as $estoque) {
            // dd(
            //     $estoque->produto->variacoes_disponiveis
            // );
            $item = [
                'id_produto' => $estoque->id_produto,
                'nome_produto' => $estoque->produto->nome,
                'descricao_produto' => $estoque->produto->descricao,
                'variacoes' => [],
                'quantidade' => $estoque->quantidade
            ];

            foreach ($estoque->produto_variacoes->opcoes as $p_variacao_opcao) {
                $item['variacoes'][$p_variacao_opcao->opcao->variacao->nome_variacao] = $p_variacao_opcao->opcao->valor;
            }

            $array[] = $item;
        }


        return Inertia::render('Comprar', [
            'estoque' => $array
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'descricaoProduto' => 'required|string',
            'nomeProduto' => 'required|string',
            'precoProduto' => 'required|numeric',
            'quantidadeProduto' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()
            ]);
        }

        $produto = new Produto();
        $produto->descricao = $request->descricaoProduto;
        $produto->nome = $request->nomeProduto;
        $produto->preco = $request->precoProduto;
        $produto->save();

        $produto_variacoes = new ProdutoVariacoes();
        $produto_variacoes->id_produto = $produto->id;
        $produto_variacoes->preco_variacao = $request->precoProduto;
        $produto_variacoes->save();

        if (!$request->variacoesSelecionadas) {
            return response([
                'message' => 'Por favor inclua uma variação'
            ], 400);
        }


        foreach ($request->variacoesSelecionadas as $value) {
            $produto_opcoes = new ProdutoVariacoesOpcoes();
            $produto_opcoes->id_produto_variacoes = $produto_variacoes->id;
            $produto_opcoes->id_opcoes_variacoes = $value['opcao_id'];
            $produto_variacoes->sku .= mb_strtoupper(mb_substr(OpcoesVariacoes::find($produto_opcoes->id_opcoes_variacoes)->valor, 0, 3,)) . '-';
            $produto_opcoes->save();
        }
        $produto_variacoes->save();

        $estoque = new Estoque();
        $estoque->id_produto = $produto->id;
        $estoque->id_produto_variacoes = $produto_variacoes->id;
        $estoque->quantidade = $request->quantidadeProduto;
        $estoque->save();

        return response([
            'message' => 'Estoque cadastrado com sucesso!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
