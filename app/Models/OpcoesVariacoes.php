<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpcoesVariacoes extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function variacao()
    {
        return $this->belongsTo(Variacao::class, 'id_variacao', 'id');
    }

    public function produtoVariacoes()
    {
        return $this->belongsToMany(ProdutoVariacoes::class, 'produto_variacoes', 'id_produto_variacoes', 'id_opcoes_variacoes', 'id', 'id');
    }
}
