<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

// Esse é o Model da tabela usuarios

class Usuario extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // coloca o que vai trazer do banco
    protected $fillable = [
        'id', 'usuario', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    // o que não vai trazer do banco
    protected $hidden = [
        'password',
    ];

    // pega a chave que vai identificar o user no token
    public function getJWTIdentifier() 
    {
        return $this->getKey();
    }

    // serve para retorna as informações do model
    public function getJWTCustomClaims()
    {
        return []; // retorna vazio pq vai add as info quando gerar o token
    }
}
