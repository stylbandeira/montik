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
        // dd($request->all());
        $request->validate([
            'nome_variacao' => 'required|string',
            'descricao_variacao' => 'required|string',
        ]);

        Variacao::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Variacao  $variacao
     * @return \Illuminate\Http\Response
     */
    public function show(Variacao $variacao)
    {
        //
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
    public function update(Request $request, Variacao $variacao)
    {
        //
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
