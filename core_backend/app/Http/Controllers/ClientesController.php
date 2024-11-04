<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Clientes::all();
        return response()->json([$clientes, 200]);
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
            "telefono" => "required|numeric",
            'tipo_documento' => 'required|string',
            'numero_documento' => 'required|string',
            'comentarios' => 'nullable'
        ];

        $validador = Validator::make($request->all(),$reglas);
        if ($validador->fails()) {
            return response()->json([
                'error' => 'Ha ocurrido un error al validar los datos enviados',
                'mensaje' => $validador->errors()
            ], 422);
        }
        try {
            //Verificar cliente por numero de celular
            if (Clientes::where('telefono',$request->telefono)->exists()) {
                return response()->json([
                    'error' => 'Ya existe un cliente con ese telefono',
                ], 422);}

                $cliente = new Clientes();
                $cliente->nombre = $request->nombre;
                $cliente->telefono = $request->telefono;
                $cliente->tipo_documento = $request->tipo_documento;
                $cliente->numero_documento = $request->numero_documento;
                $cliente->comentarios = $request->comentarios;
                $cliente->save();

                return response()->json([
                    'mensaje' => 'Se ha creado el cliente ' . $cliente->nombre,
                    'data' => $cliente
                ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al agregar el cliente en la base de datos',
                'mensaje' => $e->getMessage()
            ], 500);        }
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
}
