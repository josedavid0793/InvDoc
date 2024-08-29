<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Usuario extends Model
{
    public function tipoDocumento(){
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento', 'codigo');
    }
    use HasFactory;
    protected $table='usuarios';
    protected $fillable = ['id','nombres','apellidos','email','tipo_documento','numero_documento','telefono'];
}
