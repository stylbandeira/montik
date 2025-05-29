<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrePedidoItens extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pre_pedido_itens';

    public function pre_pedido()
    {
        return $this->belongsTo(PrePedido::class, 'id_pre_pedido', 'id');
    }

    public function produtoVariacao()
    {
        return $this->hasOne(ProdutoVariacoes::class, 'id_produto_variacoes', 'id');
    }
}
