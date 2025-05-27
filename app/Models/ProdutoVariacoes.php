<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoVariacoes extends Model
{
    use HasFactory;

    public function opcoes()
    {
        return $this->belongsToMany(OpcoesVariacoes::class, 'produto_variacoes_opcoes', 'id_produto_variacoes', 'id_opcoes_variacoes')
            ->withPivot('id')
            ->withTimestamps();
    }

    public function estoque()
    {
        return $this->hasOne(Estoque::class, 'id_produto_variacoes');
    }
}
