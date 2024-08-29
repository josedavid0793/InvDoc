<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producto = Producto::all();
        return response()->json([$producto, 200]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $reglas = [
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string|max:1000',
            'precio_unidad' => 'nullable|numeric|regex:/^\d+$/',
            'costo_unidad' => 'nullable|numeric|regex:/^\d+$/',
            'codigo' => 'nullable|string|max:50',
            'cantidad_disponible' => 'nullable|numeric|regex:/^\d+$/',
            'imagen' => 'nullable|string|max:500',
            'categoria' => 'nullable|string|max:100',
        ];

        $validador = Validator::make($request->all(),$reglas);

        if ($validador->fails()) {
            return response()->json([
                'error' => 'Ha ocurrido un error al validar los datos enviados',
                'mensaje' => $validador->errors()
            ],422);
        }

        try {
            $producto = new Producto();
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->precio_unidad = $request->precio_unidad;
            $producto->costo_unidad = $request->costo_unidad;
            $producto->codigo = $request->codigo;
            $producto->cantidad_disponible = $request->cantidad_disponible;
            $producto->imagen = $request->imagen;
            $producto->categoria = $request->categoria;
            $producto->save();
            return response()->json([
                'mensaje' => 'Se ha creado el producto ' . $producto->nombre,
                'data' => $producto
            ],200,[],JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al agregar el producto en la base de datos',
                'mensaje' => $e->getMessage()
            ],500);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto=Producto::findOrFail($id);
        try {
            return response()->json([
                'mensaje' => 'Se consulto el producto ' . $producto->nombre . ' de la base de datos',
                'data' => $producto
            ],200,[],JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se obtuvo el producto solicitado',
                'mensaje' => $e->getMessage()
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reglas = [
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string|max:1000',
            'precio_unidad' => 'nullable|numeric|regex:/^\d+$/',
            'costo_unidad' => 'nullable|numeric|regex:/^\d+$/',
            'codigo' => 'nullable|string|max:50',
            'cantidad_disponible' => 'nullable|numeric|regex:/^\d+$/',
            'imagen' => 'nullable|string|max:500',
            'categoria' => 'nullable|string|max:100',
        ];

        $validador = Validator::make($request->all(),$reglas);

        if ($validador->fails()) {
            return response()->json([
                'error' => 'Ha ocurrido un error al validar los datos enviados',
                'mensaje' => $validador->errors()
            ],422);
        }
        try {
            $producto = Producto::findOrFail($id);
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->precio_unidad = $request->precio_unidad;
            $producto->costo_unidad = $request->costo_unidad;
            $producto->codigo = $request->codigo;
            $producto->cantidad_disponible = $request->cantidad_disponible;
            $producto->imagen = $request->imagen;
            $producto->categoria = $request->categoria;
            $producto->save();
            return response()->json([
                'mensaje' => 'Se ha actualizado el producto ' . $producto->nombre,
                'data' => $producto
            ],200,[],JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al actualizar el producto en la base de datos',
                'mensaje' => $e->getMessage()
            ],404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $producto=Producto::findOrFail($id);
            $producto->delete();
            return response()->json([
                'mensaje' => 'Se ha eliminado el producto ' . $producto->nombre . ' de la base de datos',
                'data' => $producto
            ],200,[],JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se elimino el producto deseado',
                'mensaje' => $e->getMessage()
            ],404);
        }
    }
}
