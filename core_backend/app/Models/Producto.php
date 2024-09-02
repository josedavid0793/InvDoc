<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 


class Producto extends Model
{
    public function categoria()
{
    return $this->belongsTo(Categoria::class, 'categoria', 'nombre');
}
    use HasFactory;
    protected $table="productos";
    protected $fillable = ['id','nombre','descripcion','precio_unidad','costo_unidad','codigo','cantidad_disponible','imagen','categoria'];

    /**
     * Calcular el costo total de todos los productos.
     *
     * @return float
     */
    public static function calcularCostoTotal()
    {
        return self::sum(DB::raw('costo_unidad * cantidad_disponible'));
    }
}
