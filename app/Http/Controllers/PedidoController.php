<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->user()) {
            //GUARDA NUMA TABELA DE PEDIDOS TEMPORÁRIOS (PRE_PEDIDO_ITENS)
            dd('AA');
            //REDIRECIONA PARA O CADASTRO E GUARDA OS DADOS TEMPORÁRIOS (PRE_PEDIDO)
            return Inertia::render();
        }

        //CRIA UM CARRINHO ATRIBUÍDO AO USUÁRIO LOGADO
        //OU
        //TRANSFERE O PRE_PEDIDO_ITENS PARA O CARRINHO E SOFTDELETA O REGISTRO EM PRE_PEDIDO_ITENS

        //AO FINALIZAR O CADASTRO, ATRIBUIR O PEDIDO AO USUÁRIO CRIADO
        //AO FAZER O LOGIN, O USUÁRIO PODERÁ ACESSAR O PEDIDO DELE
        //
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
