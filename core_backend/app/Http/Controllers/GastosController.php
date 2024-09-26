<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gastos;
use Illuminate\Support\Facades\Validator;
use App\Events\GastosAgregado;


class GastosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gastos = Gastos::all();
        return response()->json([$gastos, 200]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas = [
            'valor' => 'required|integer|min:0',
            'concepto' => 'nullable|string|max:500',
            'modalidad_pago' => 'required|string|max:100',
            'metodo_pago' => 'required|string|max:100',
            'proveedor' => 'required|string|max:200',
            'fecha' => 'required|date',
            'categoria_gasto' => 'required|string|max:200',
        ];
        // Validación de los datos recibidos
        $validador = Validator::make($request->all(), $reglas);

        if ($validador->fails()) {
            return response()->json([
                'error' => 'Ha ocurrido un error al validar los datos enviados',
                'mensaje' => $validador->errors()
            ], 422);
        }
        try {
            // Crear y almacenar el gasto
            $gastos = new Gastos();
            $gastos->valor = $request->valor;
            $gastos->concepto = $request->concepto;
            $gastos->modalidad_pago = $request->modalidad_pago;
            $gastos->metodo_pago = $request->metodo_pago;
            $gastos->proveedor = $request->proveedor;
            $gastos->fecha = $request->fecha;
            $gastos->categoria_gasto = $request->categoria_gasto;
            $gastos->save();
            // Emitir el evento para actualizar el frontend en tiempo real
            event(new GastosAgregado($gastos));

            return response()->json([
                'mensaje' => 'Se ha creado el gasto ' . $gastos->id,
                'data' => $gastos
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al agregar el gasto en la base de datos',
                'mensaje' => $e->getMessage()
            ], 500);       
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sumarGastosTotales()
    {
        // Sumar todas las ventas (valor_total)
        $totalGastos = Gastos::sum('valor');

        return response()->json([
            'total' => $totalGastos
        ], 200);
    }
    public function contarGastos()
    {
        // Contar el total de productos
        $totalGastos = Gastos::count();

        // Devolver el resultado como respuesta JSON
        return response()->json([
            'total' => $totalGastos
        ]);
    }
    public function obtenerTotalGastosPorEfectivo()
    {
        $totalGastosEfectivo = Gastos::where('metodo_pago', 'Efectivo')
        ->where('modalidad_pago', 'Pagada')
        ->sum('valor');

        return response()->json(['total' => $totalGastosEfectivo]);
    }

    public function obtenerTotalGastosNoEfectivo()
    {
        // Filtrar las ventas donde el metodo_pago sea diferente de 'efectivo'
        $totalGastosNoEfectivo = Gastos::where('metodo_pago', '!=', 'Efectivo')
        ->where('modalidad_pago', 'Pagada')
            ->sum('valor'); // 'total' es el campo que contiene el valor de la venta

        return response()->json(['total' => $totalGastosNoEfectivo]);
    }
    public function obtenerTotalGastosPorEfectivoCredito()
    {
        $totalGastosCrediEfectivo = Gastos::where('metodo_pago', 'Efectivo')
        ->where('modalidad_pago', 'A crédito')
        ->sum('valor');

        return response()->json(['total' => $totalGastosCrediEfectivo]);
    }
    public function obtenerTotalGastosNoEfectivoCredito()
    {
        // Filtrar las ventas donde el metodo_pago sea diferente de 'efectivo'
        $totalGastosNoEfectivo = Gastos::where('metodo_pago', '!=', 'Efectivo')
        ->where('modalidad_pago', 'A crédito')
            ->sum('valor'); // 'total' es el campo que contiene el valor de la venta

        return response()->json(['total' => $totalGastosNoEfectivo]);
    }
}
