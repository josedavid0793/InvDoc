<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ventas;
use Illuminate\Support\Facades\Validator;
use App\Events\VentasAgregada;


class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas = Ventas::all();
        return response()->json([$ventas, 200]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Actualizamos las reglas eliminando 'valor_total' ya que se calculará en el servidor
        $reglas = [
            'fecha' => 'required|date',
            'valor' => 'required|integer|min:0',
            'iva' => 'nullable|integer|min:0',
            'concepto' => 'nullable|string|max:500',
            'nombre_producto' => 'required|string|max:200',
            'cantidad' => 'nullable|integer|min:0',
            'modalidad_pago' => 'required|string|max:100',
            'metodo_pago' => 'required|string|max:100',
            'nombre_cliente' => 'nullable|string|max:200',
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
            // Cálculo del valor total (valor + iva)
            $valor = $request->valor;
            $iva = $request->iva ?? 0; // Si IVA es nulo, asumimos que es 0
            $valor_total = $valor + $iva;

            // Crear y almacenar la venta
            $ventas = new Ventas();
            $ventas->fecha = $request->fecha;
            $ventas->valor = $valor;
            $ventas->iva = $iva;
            $ventas->valor_total = $valor_total; // Guardamos el valor total calculado
            $ventas->concepto = $request->concepto;
            $ventas->nombre_producto = $request->nombre_producto;
            $ventas->cantidad = $request->cantidad;
            $ventas->modalidad_pago = $request->modalidad_pago;
            $ventas->metodo_pago = $request->metodo_pago;
            $ventas->nombre_cliente = $request->nombre_cliente;
            $ventas->save();

            // Emitir el evento para actualizar el frontend en tiempo real
            event(new VentasAgregada($ventas));

            return response()->json([
                'mensaje' => 'Se ha creado la venta ' . $ventas->id,
                'data' => $ventas
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al agregar la venta en la base de datos',
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
        $ventas = Ventas::findOrFail($id);
        try {
            return response()->json([
                'mensaje' => 'Se consulto la venta ' . $ventas->id . ' de la base de datos',
                'data' => $ventas
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se obtuvo la venta solicitada',
                'mensaje' => $e->getMessage()
            ], 404);
        }
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
        $reglas = [
            'fecha' => 'required|date',
            'valor' => 'required|integer|min:0',
            'iva' => 'nullable|integer|min:0',
            'concepto' => 'nullable|string|max:500',
            'nombre_producto' => 'required|string|max:200',
            'cantidad' => 'nullable|integer|min:0',
            'modalidad_pago' => 'required|string|max:100',
            'metodo_pago' => 'required|string|max:100',
            'nombre_cliente' => 'nullable|string|max:200',
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
            $ventas = Ventas::findOrFail($id);
            // Cálculo del valor total (valor + iva)
            $valor = $request->valor;
            $iva = $request->iva ?? 0; // Si IVA es nulo, asumimos que es 0
            $valor_total = $valor + $iva;

            // Crear y almacenar la venta
            $ventas->fecha = $request->fecha;
            $ventas->valor = $valor;
            $ventas->iva = $iva;
            $ventas->valor_total = $valor_total; // Guardamos el valor total calculado
            $ventas->concepto = $request->concepto;
            $ventas->nombre_producto = $request->nombre_producto;
            $ventas->cantidad = $request->cantidad;
            $ventas->modalidad_pago = $request->modalidad_pago;
            $ventas->metodo_pago = $request->metodo_pago;
            $ventas->nombre_cliente = $request->nombre_cliente;
            $ventas->save();
            event(new VentasAgregada($ventas));

            return response()->json([
                'mensaje' => 'Se ha actualizado la venta ' . $ventas->id,
                'data' => $ventas
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al actualizar la venta en la base de datos',
                'mensaje' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $ventas = Ventas::findOrFail($id);
            $ventas->delete();
            return response()->json([
                'mensaje' => 'Se ha eliminado la venta ' . $ventas->id . ' de la base de datos',
                'data' => $ventas
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se elimino la venta deseada',
                'mensaje' => $e->getMessage()
            ], 404);
        }
    }

    public function sumarVentasTotales()
    {
        // Sumar todas las ventas (valor_total)
        $totalVentas = Ventas::sum('valor_total');

        return response()->json([
            'total' => $totalVentas
        ], 200);
    }
}
