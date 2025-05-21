<?php

namespace App\Http\Controllers;

use App\Models\Variacao;
use Illuminate\Http\Request;

class VariacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $variacoes = Variacao::all();
        return response([
            'variacoes' => $variacoes
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
        $request->validate([
            'nome_variacao' => 'required|string',
            'descricao_variacao' => 'required|string',
        ]);

        $variacao = Variacao::create($request->all());
        return response([
            'message' => 'Variação criada com sucesso',
            'variacao' => $variacao
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Variacao  $variacao
     * @return \Illuminate\Http\Response
     */
    public function show(Int $id)
    {
        $variacao = Variacao::find($id);

        if ($variacao) {
            return response([
                'variacao' => $variacao
            ]);
        } else {
            return response([
                'message' => 'Variação não encontrada'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Variacao  $variacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Variacao $variacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Variacao  $variacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Int $id)
    {
        $variacao = Variacao::find($id);

        if ($variacao) {
            $variacao->update($request->all());
            return response([
                'message' => 'Variação alterada com sucesso!',
                'variacao' => $variacao
            ]);
        } else {
            return response([
                'message' => 'Variação não encontrada'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Variacao  $variacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variacao $variacao)
    {
        //
    }
}
