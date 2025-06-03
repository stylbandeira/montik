<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
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
        Log::alert($request->all());
        //VALIDA OS DADOS DE ENDEREÇO
        $validator = Validator::make($request->all(), [
            'rua' => 'required|string',
            'numero' => 'required|string',
            'complemento' => 'required|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string',
            'cep' => 'required|integer',
            'frete' => 'required|decimal:2:8'
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()
            ]);
        }

        //VERIFICA SE O USUÁRIO ESTÁ LOGADO OU NÃO
        if ($request->user()) {
        } else {
            // CRIA UM PRE_PEDIDO OU RECUPERA O PRE-PEDIDO BASEADO NO UUID
            $pre_pedido = PrePedido::firstOrNew(['uuid' => $request->uuid]);
            // SE FOR O MESMO UUID E O MESMO ENDEREÇO, APENAS PEGA O ENDEREÇO.
            $endereco = Endereco::firstOrNew([
                'uuid' => $request->uuid,
                'rua' => $request->rua,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
                'cep' => $request->cep,
            ]);

            $pre_pedido->id_endereco = $endereco->id;
            $pre_pedido->frete = $request->frete;
        }

        //CRIA O ENDEREÇO ANYWAY
        $endereco->rua = $request->rua;
        $endereco->numero = $request->numero;
        $endereco->complemento = $request->complemento;
        $endereco->bairro = $request->bairro;
        $endereco->cidade = $request->cidade;
        $endereco->estado = $request->estado;
        $endereco->cep = $request->cep;
        // $endereco->save();

        //RODA DENTRO DOS PRODUTOS
        foreach ($request->carrinho as $produtos) {

            $estoque = Estoque::where('id_produto_variacoes', $produtos['id_produto_variacao'])->first();
            $itens_em_pre_pedido = PrePedidoItens::where('id_produto_variacoes', $produtos['id_produto_variacao'])
                ->get();

            if (!$estoque) {
                return response([
                    'message' => 'Produto em falta no estoque'
                ], 400);
            }

            //VERIFICA SE EXISTE A QUANTIDADE SOLICITADA DE ITENS DAQUELA VARIAÇÃO EM ESTOQUE
            // ############ ITENS DESSE PEDIDO + ITENS DOS PRE_PEDIDOS - ITENS DO ESTOQUE ############
            $produtos_em_estoque = $estoque->quantidade - $itens_em_pre_pedido->sum('quantidade');

            if ($produtos_em_estoque - $produtos['quantidade'] < 0) {
                return response([
                    'message' => 'Produto em falta no estoque'
                ], 400);
            }

            //SE SIM, CRIA O PRE_PEDIDO
            $pre_pedido_itens = new PrePedidoItens();
            $pre_pedido_itens->quantidade = $produtos['quantidade'];
            $pre_pedido_itens->id_produto_variacoes = $produtos['id_produto_variacao'];
            $pre_pedido_itens->id_pre_pedido = $pre_pedido->id;
            // $pre_pedido_itens->save();

            // #### ANTIGA LÓGICA ####
            //CASO EXISTA AQUELA QUANTIDADE, O ESTOQUE É ATUALIZADO E ADICIONADO AO PRE_PEDIDO_ITENS
            // $estoque->quantidade -= $produtos['quantidade'];
            // $estoque->save();
            // #### ANTIGA LÓGICA ####

        }

        //APÓS CRIAR O PRE_PEDIDO, RETORNA O PEDIDO,

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
