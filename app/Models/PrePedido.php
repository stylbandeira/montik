<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrePedido extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pre_pedido';
    protected $fillable = ['uuid'];

    public function produtos()
    {
        return $this->hasMany(PrePedidoItens::class, 'id_pre_pedido', 'id');
    }
}
