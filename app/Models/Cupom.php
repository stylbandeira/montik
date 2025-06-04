<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cupom extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cupons';
    protected $fillable = [
        'valido_ate',
        'tipo_desconto',
        'desconto',
        'quantidade',
        'codigo',
        'val_minimo'
    ];

    protected $casts = [
        'valido_ate' => 'datetime:d/m/Y',
    ];
}
