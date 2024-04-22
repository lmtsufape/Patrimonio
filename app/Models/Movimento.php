<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    use HasFactory;

    public static $tipos = [
        'solicitacao' => 1,
        'emprestimo' => 2,
        'devolucao' => 3,
        'particular' => 4,
        'transferencia' => 5
    ];

    public function patrimonios()
    {
        return $this->belongsToMany(Patrimonio::class);
    }

    public function movimentable()
    {
        return $this->morphTo();
    }
}
