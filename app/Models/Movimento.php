<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimento extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['tipo', 'status','data', 'motivo', 'user_origem_id', 'user_destino_id', 'sala_id', 'cidade', 'logradouro', 'numero', 'bairro', 'evento'];
    public static $tipos = [//biblioteca de enum
        'Solicitação' => 1,
        'Emprestimo' => 2,
        'Devolução' => 3,
        'Transferência' => 4
    ];

    public function patrimonios()
    {
        return $this->belongsToMany(Patrimonio::class, 'movimento_patrimonio', 'movimento_id', 'patrimonio_id');
    }

    public function userOrigem()
    {
        return $this->belongsTo(User::class, 'user_origem_id', 'id');
    }

    public function userDestino()
    {
        return $this->belongsTo(User::class, 'user_destino_id', 'id');
    }
}
