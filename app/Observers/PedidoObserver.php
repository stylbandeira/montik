<?php

namespace App\Observers;

use App\Models\PrePedido;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PedidoObserver
{
    public function creating(PrePedido $pedido)
    {
        $ultimoId = PrePedido::withTrashed()->max('id') + 1;
        $pedido->codigo = 'PED-' . str_pad($ultimoId, 6, '0', STR_PAD_LEFT);

        Log::alert(['SAVING' => $pedido->codigo]);
        $pedido->status = 'PENDENTE';
    }

    public function saving(PrePedido $pedido) {}
}
