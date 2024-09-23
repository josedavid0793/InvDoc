<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalidadPago extends Model
{
    use HasFactory;
    protected $table="modalidad_pago";
    protected $fillable=['id','modalidad'];
}
