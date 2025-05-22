<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variacao extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome_variacao',
        'descricao_variacao'
    ];
    protected $table = 'variacoes';

    public function opcoes()
    {
        return $this->hasMany(OpcoesVariacoes::class, 'id_variacao', 'id');
    }
}
