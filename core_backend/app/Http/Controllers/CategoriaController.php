<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoria = Categoria::all();
        return response()->json([$categoria, 200]);
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
            "nombre" => "required|string|max:100",
            "descripcion" => "nullable|string|max:500"
        ];
        $validador = Validator::make($request->all(), $reglas);
        if ($validador->fails()) {
            return response()->json([
                'error' => 'Ha ocurrido un error al validar los datos enviados',
                'mensaje' => $validador->errors()
            ], 422, [], JSON_UNESCAPED_UNICODE);
        }
        try {
            $categoria = new Categoria();
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            $categoria->save();
            return response()->json([
                'mensaje' => 'Se ha creado la categoría ' . $categoria->nombre,
                'data' => $categoria
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al agregar la categoría en la base de datos',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        try {
            return response()->json([
                'mensaje' => 'Se consulto la categoria ' . $categoria->nombre,
                'data' => $categoria
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se obtuvo la categoría solicitada',
                'mensaje' => $e->getMessage()
            ], 500);
        }
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
            "nombre" => "required|string|max:100",
            "descripcion" => "nullable|string|max:500"
        ];
        $validador = Validator::make($request->all(), $reglas);
        if ($validador->fails()) {
            return response()->json([
                'error' => 'Ha ocurrido un error al validar los datos enviados',
                'mensaje' => $validador->errors()
            ], 422, [], JSON_UNESCAPED_UNICODE);
        }
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            $categoria->save();
            return response()->json([
                'mensaje' => 'Se ha actualizado la categoría ' . $categoria->nombre,
                'data' => $categoria
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al actualizar la categoría en la base de datos',
                'mensaje' => $e->getMessage()
            ], 500);
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
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();
            return response()->json([
                'mensaje' => 'Se ha eliminado la categoría ' . $categoria->nombre,
                'data' => $categoria
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se elimino la categoría deseada',
                'mensaje' => $e->getMessage()
            ],500);
        }
    }
}
