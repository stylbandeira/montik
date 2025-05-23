<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\Produto;
use App\Models\ProdutoVariacoes;
use App\Models\ProdutoVariacoesOpcoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstoqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $produto_opcoes->save();
        }

        $estoque = new Estoque();
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
