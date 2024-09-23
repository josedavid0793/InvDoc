<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model

{
    public function nombreProducto(){
        return $this->belongsTo(Producto::class, 'nombre_producto', 'nombre');
    }

    public function modalidadPago(){
        return $this->belongsTo(ModalidadPago::class, 'modalidad_pago', 'modalidad');
    }

    public function metodoPago(){
        return $this->belongsTo(MetodoPago::class, 'metodo_pago', 'metodo');
    }

    public function nombreCliente(){
        return $this->belongsTo(Clientes::class, 'nombre_cliente', 'nombre');
    }
    use HasFactory;
    protected $table = "ventas";
    protected $fillable = ['id', 'fecha', 'valor', 'iva', 'valor_total', 'concepto', 'nombre_producto', 'cantidad', 'modalidad_pago', 'metodo_pago', 'nombre_cliente'];
}
