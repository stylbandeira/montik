<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\PrePedido;
use App\Models\PrePedidoItens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class PedidoController extends Controller
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
    public function create(Request $request)
    {
        return Inertia::render('Checkout', []);
        //PEGAR EMAIL
        //PEGAR CEP E ENDEREÇO
        // if (!$request->email || $request->user()->email) {
        //     return response([
        //         'message' => 'Email necessário'
        //     ]);
        // }

        // if ($request->user()) {
        // } else {
        //     // CRIA UM PRE_PEDIDO OU RECUPERA O PRE-PEDIDO BASEADO NO UUID
        //     $pre_pedido = PrePedido::firstOrNew(['uuid' => $request->uuid]);
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //VERIFICA SE O USUÁRIO ESTÁ LOGADO OU NÃO
        if ($request->user()) {
        } else {
            // CRIA UM PRE_PEDIDO OU RECUPERA O PRE-PEDIDO BASEADO NO UUID
            $pre_pedido = PrePedido::firstOrNew(['uuid' => $request->uuid]);
        }

        foreach ($request->carrinho as $produtos) {

            $estoque = Estoque::where('id_produto_variacoes', $produtos['id_produto_variacao'])->first();

            //VERIFICA SE EXISTE A QUANTIDADE SOLICITADA DE ITENS DAQUELA VARIAÇÃO EM ESTOQUE
            if (!$estoque || ($estoque->quantidade < $produtos['quantidade'])) {
                return response([
                    'message' => 'Produto em falta no estoque'
                ], 400);
            }

            //CASO EXISTA AQUELA QUANTIDADE, O ESTOQUE É ATUALIZADO E ADICIONADO AO PRE_PEDIDO_ITENS
            $estoque->quantidade -= $produtos['quantidade'];
            // $estoque->save();

            $pre_pedido_itens = new PrePedidoItens();
            $pre_pedido_itens->quantidade = $produtos['quantidade'];
            $pre_pedido_itens->id_produto_variacoes = $produtos['id_produto_variacao'];
            $pre_pedido_itens->id_pre_pedido = $pre_pedido->id;
            // $pre_pedido->itens->save();

        }

        //SE O USUÁRIO TIVER LOGADO, JOGAR O PRE_PEDIDO_ITENS PARA O CARRINHO TAMBÉM
        //REDIRECIONA PARA A PÁGINA DE CHECKOUT
        // $this->create();

        //####### PARA DEPOIS ###########
        //DEVE SER CRIADO UM JOB PARA REMOVER OS PEDIDOS EM PRE_PEDIDO QUE TENHAM MAIS DE 3 DIAS DE CRIAÇÃO

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
