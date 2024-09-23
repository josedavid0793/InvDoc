<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    public function tipoDocumento(){
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento', 'codigo');
    }
    use HasFactory;
    protected $table="clientes";
    protected $fillable = ['id','nombre','telefono','tipo_documento','numero_documento','comentarios'];
}
