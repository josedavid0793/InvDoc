<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaGastos extends Model
{
    use HasFactory;
    protected $table="categorias_gastos";
    protected $fillable = ['id','categoria'];
}
