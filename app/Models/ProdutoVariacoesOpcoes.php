<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoVariacoesOpcoes extends Model
{
    use HasFactory;
    protected $table = 'produto_variacoes_opcoes';

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto_variacoes', 'id');
    }

    public function opcao()
    {
        return $this->belongsTo(OpcoesVariacoes::class, 'id_opcoes_variacoes', 'id');
    }
}
