<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'telefone', 'predio_id'];

    public function predio()
    {
        return $this->belongsTo(Predio::class);
    }

    public function unidades(){
        return $this->belongsToMany(UnidadeAdministrativa::class, 'sala_unidade_administrativa', 'unidade_admin_id', 'sala_id');
    }
    
    public function patrimonios()
    {
        return $this->hasMany(Patrimonio::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
