<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subgrupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'marca', 'modelo', 'classificacao_id', 
    ];

    public function classificacao()
    {
        return $this->belongsTo(Classificacao::class);
    }

    public function patrimonios()
    {
        return $this->hasMany(Patrimonio::class);
    }
}
