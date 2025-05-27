<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'produtos';
    protected $fillable = [
        'nome',
        'preco',
        'descricao'
    ];

    public function variacoes()
    {
        return $this->hasMany(ProdutoVariacoes::class, 'id_produto', 'id');
    }

    public function estoque()
    {
        return $this->hasMany(Estoque::class, 'id_produto', 'id');
    }

    public function variacoesProduto()
    {
        return $this->hasMany(ProdutoVariacoes::class, 'id_produto', 'id');
    }

    public function getVariacoesDisponiveisAttribute()
    {

        return $this->whereHas('variacoes', function ($query) {
            $query->whereHas('estoque', function ($query) {
                $query->where('quantidade', '>', 0);
            });
        })
            ->whereHas('variacoes.opcoes')
            ->with('variacoes.opcoes.variacao')
            ->get();
    }
}
