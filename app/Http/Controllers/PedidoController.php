<?php

namespace App\Http\Controllers;

use App\Mail\PedidoConfirmado;
use App\Models\Endereco;
use App\Models\Estoque;
use App\Models\Pedido;
use App\Models\PrePedido;
use App\Models\PrePedidoItens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rua' => 'required|string',
            'numero' => 'required|string',
            'complemento' => 'required|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string',
            'cep' => 'required|integer',
            'frete' => 'required|decimal:2',
            'email' => 'required|email',
            'nome' => 'required|string',
            'subtotal' => 'required|decimal:2',
            'descontos' => 'required|decimal:2',
            'total' => 'required|decimal:2'
        ]);

        if ($validator->fails()) {

            return response([
                'errors' => $validator->errors()
            ]);
        }

        // CRIA UM PRE_PEDIDO OU RECUPERA O PRE-PEDIDO BASEADO NO UUID
        $pre_pedido = PrePedido::firstOrNew(['uuid' => $request->uuid]);

        if ($request->user()) {
        } else {

            // SE FOR O MESMO UUID E O MESMO ENDEREÇO, APENAS PEGA O ENDEREÇO.
            $endereco = Endereco::firstOrCreate([
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
            $pre_pedido->id_cupom = $request->cupom['id'] ?? null;
            $pre_pedido->email = $request->email;
            $pre_pedido->frete = $request->frete;
            $pre_pedido->subtotal = $request->subtotal;
            $pre_pedido->descontos = $request->descontos;
            $pre_pedido->total = $request->total;
            $pre_pedido->save();
        }

        // SE FOR O MESMO UUID E O MESMO ENDEREÇO, APENAS PEGA O ENDEREÇO.
        $endereco = Endereco::firstOrNew([
            'uuid' => $request->uuid,
        ]);

        $endereco->rua = $request->rua;
        $endereco->numero = $request->numero;
        $endereco->complemento = $request->complemento;
        $endereco->bairro = $request->bairro;
        $endereco->cidade = $request->cidade;
        $endereco->estado = $request->estado;
        $endereco->cep = $request->cep;
        $endereco->save();

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
            $pre_pedido_itens->save();
        }

        //ENVIA E-MAIL
        $pedido = [
            'id' => $pre_pedido->id,
            'status' => $pre_pedido->status,
            'email' => $request->email,
            'total' => $pre_pedido->total,
            'itens' => $pre_pedido_itens,
            'nome' => $request->nome,
            'link' => $pre_pedido->pedido_url
        ];
        Mail::to($pedido['email'])->send(new PedidoConfirmado($pedido));

        return response([
            'message' => 'Pedido feito com sucesso!'
        ]);

        //####### PARA DEPOIS ###########
        //DEVE SER CRIADO UM JOB PARA REMOVER OS PEDIDOS EM PRE_PEDIDO QUE TENHAM MAIS DE 3 DIAS DE CRIAÇÃO
        //E NÃO TENHAM SIDO CONFIRMADOS.

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($codigo)
    {
        $pedido = PrePedido::where('id', $codigo)
            ->orWhere('codigo', $codigo)
            ->first();

        if (!$pedido) {
            return response([
                'message' => 'Pedido não encontrado'
            ], 404);
        }

        return Inertia::render('Pedidos/PedidoDetalhes', [
            'pedido' => $pedido
        ]);
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
        $validator = Validator::make($request->all(), [
            'status' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()
            ]);
        }

        if ($request->pre_pedido) {
            $pedido = PrePedido::find($id);
        } else {
            $pedido = Pedido::find($id);
        }

        //### PARA DEPOIS ###
        //SE O PEDIDO FOR CONFIRMADO, CRIA PEDIDO E REMOVE DO ESTOQUE
        $pedido->status = $request->status;
        $pedido->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($codigo)
    {
        $pedido = PrePedido::where('codigo', $codigo)
            ->orWhere('id', $codigo)
            ->first();

        if (!$pedido) {
            return response([
                'message' => 'Pedido não encontrado'
            ], 404);
        }

        $pedido->delete();

        return response([
            'message' => 'Pedido cancelado com sucesso!'
        ], 200);
    }
}
