<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'matricula',
        'ativo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function cargos()
    {
        return $this->belongsToMany(Cargo::class, 'cargo_user', 'user_id', 'cargo_id');
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    public function patrimonios()
    {
        return $this->hasMany(Patrimonio::class);
    }

    public function unidade()
    {
        return $this->belongsTo(UnidadeAdministrativa::class, 'unidade_admin_id');
    }

    public function hasAnyRoles($tipo)
    {
        return $this->roles()->whereIn('nome', $tipo)->exists();
    }

    public function hasAnyCargos($cargo)
    {
        return $this->cargos()->WhereIn('nome', $cargo)->exists();
    }
}
