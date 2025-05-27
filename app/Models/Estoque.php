<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;
    protected $table = 'estoque';

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto', 'id');
    }

    public function produto_variacoes()
    {
        return $this->belongsTo(ProdutoVariacoes::class, 'id_produto_variacoes', 'id');
    }
}
