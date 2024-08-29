<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function categoria()
{
    return $this->belongsTo(Categoria::class, 'categoria', 'nombre');
}
    use HasFactory;
    protected $table="productos";
    protected $fillable = ['id','nombre','descripcion','precio_unidad','costo_unidad','codigo','cantidad_disponible','imagen','categoria'];
}
