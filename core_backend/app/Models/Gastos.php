<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gastos extends Model
{
    public function modalidadPago(){
        return $this->belongsTo(ModalidadPago::class, 'modalidad_pago', 'modalidad');
    }

    public function metodoPago(){
        return $this->belongsTo(MetodoPago::class, 'metodo_pago', 'metodo');
    }
    public function categoriasGastos(){
        return $this->belongsTo(CategoriaGastos::class, 'categoria_gasto', 'categoria');
    }
    use HasFactory;
    protected $table="gastos";
    protected $fillable = ['id','valor','concepto','modalidad_pago','metodo_pago','proveedor','fecha','categoria_gasto'];
}
