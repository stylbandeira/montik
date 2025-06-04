<?php

namespace App\Models;

use App\Observers\PedidoObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class PrePedido extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pre_pedido';
    protected $fillable = ['uuid', 'codigo'];
    protected $appends = ['pedido_url'];

    public function produtos()
    {
        return $this->hasMany(PrePedidoItens::class, 'id_pre_pedido', 'id');
    }

    public function getPedidoUrlAttribute()
    {
        return url('/pedidos/' . $this->codigo);
    }
}
