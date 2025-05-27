<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoVariacoes extends Model
{
    use HasFactory;

    public function opcoes()
    {
        return $this->hasMany(ProdutoVariacoesOpcoes::class, 'id_produto_variacoes');
    }

    public function estoque()
    {
        return $this->hasOne(Estoque::class, 'id_produto_variacoes');
    }
}
