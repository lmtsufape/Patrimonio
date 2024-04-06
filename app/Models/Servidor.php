<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    use HasFactory;

    protected $table = 'servidores';

    protected $fillable = ['cpf', 'matricula', 'user_id', 'cargo_id', 'ativo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cargos()
    {
        return $this->belongsToMany(Cargo::class);
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }
}
