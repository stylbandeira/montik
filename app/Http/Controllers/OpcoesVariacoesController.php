<?php

namespace App\Http\Controllers;

use App\Models\OpcoesVariacoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OpcoesVariacoesController extends Controller
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
            'id_variacao' => 'required',
            'valor' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response($validator->errors());
        }

        $opcao_variacao = new OpcoesVariacoes();
        $opcao_variacao->id_variacao = $request->id_variacao;
        $opcao_variacao->valor = $request->valor;
        $opcao_variacao->save();

        return response([
            'message' => 'Variação cadastrada com sucesso!',
            'variação' => $opcao_variacao->variacao->nome_variacao,
            'opcao' => $opcao_variacao->valor
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
