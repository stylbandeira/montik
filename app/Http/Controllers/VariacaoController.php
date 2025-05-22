<?php

namespace App\Http\Controllers;

use App\Models\Variacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'nome_variacao' => 'required|string',
            'descricao_variacao' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response($validator->errors());
        }

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
    public function destroy(Int $id)
    {
        $variacao = Variacao::find($id);

        if (!$variacao) {
            return response([
                'message' => 'Variacao não encontrada'
            ], 404);
        }

        $variacao->delete();

        return response([
            'message' => 'Variacao deletada com sucesso!',
            'variacao' => $variacao
        ]);
    }
}
