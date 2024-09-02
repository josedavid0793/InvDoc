<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable /*implements JWTSubject*/
{
  use HasFactory;
    protected $table='usuarios';
    protected $fillable = ['id','nombres','apellidos','email','password','tipo_documento','numero_documento','telefono'];


    protected $hidden = [
        'password', 'remember_token',
    ];


   /* public function getJWTIdentifier()
    {
        return $this->getKey();
    }*/

/*
    public function getJWTCustomClaims()
    {
        return [];
    }
*/
    public function tipoDocumento(){
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento', 'codigo');
    }
}
