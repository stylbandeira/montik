<?php

namespace App\Http\Controllers;

use App\Models\Cupom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CupomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $cupom = Cupom::query();

        // if ($request->has('codigo')) {
        //     $cupom->where('codigo', $request->codigo)
        //         ->where('quantidade', '>', 0);

        //     if ($cupom->count()) {
        //         return response([
        //             'cupom' => $cupom->first()
        //         ]);
        //     }

        //     return response([
        //         'message' => 'Cupom não encontrado.'
        //     ], 400);
        // }

        // return $cupom->all();
        $cupons = Cupom::all();

        return response([
            'cupons' => $cupons
        ]);
    }

    public function validaCupom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subtotalPedido' => 'required|decimal:2',
            'codigo' => 'required|string'
        ]);

        if ($validator->fails()) {
            Log::alert(['FALHOU' => $validator->errors()]);
            return response([
                'errors' => $validator->errors()
            ]);
        }

        $cupom = Cupom::where('codigo', $request->codigo)
            ->where('quantidade', '>', 0);

        if (!$cupom->count()) {
            return response([
                'message' => 'Cupom não encontrado'
            ], 400);
        }

        $cupom->where('val_minimo', '<', $request->subtotalPedido);

        if (!$cupom->count()) {
            return response([
                'message' => 'Valor mínimo abaixo do permitido!'
            ], 400);
        }

        return response([
            'cupom' => $cupom->first()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cupons = Cupom::all();

        return Inertia::render('Cupons', [
            'cupons' => $cupons
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::alert($request->val_minimo);
        Log::alert($request->desconto);

        $validator = Validator::make($request->all(), [
            'valido_ate' => 'required|date',
            'tipo_desconto' => 'required|string',
            'desconto' => 'required|decimal:2',
            'quantidade' => 'required|integer',
            'codigo' => 'required|unique:cupons,codigo'
        ]);

        if ($validator->fails()) {
            Log::alert($validator->errors());
            return response([
                'errors' => $validator->errors()
            ]);
        }

        $cupom = Cupom::create($request->all());

        return response([
            'cupom' => $cupom
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        Log::alert('aa');
        $cupom = Cupom::query();

        if ($request->has('codigo')) {
            $cupom->where('codigo', $request->codigo);
        }

        Log::alert($request->all());
        Log::alert('aa');

        return $cupom->get();
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
