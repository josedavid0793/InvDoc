<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Usuario::all();
        return response()->json([$usuario, 200]);
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
            'nombres' => 'required|string|max:200',
            'apellidos' => 'nullable|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:300',
            'contraseña' => 'required|string|max:500',
            'confirmar_contraseña' => 'required|string|max:500|same:contraseña',
            'tipo_documento' => 'required|string',
            'numero_documento' => 'required|string',
            'telefono' => 'required|numeric',
        ];

        $validador = Validator::make($request->all(), $reglas);
        if ($validador->fails()) {
            return response()->json([
                'error' => 'Ha ocurrido un error al validar los datos enviados',
                'mensaje' => $validador->errors()
            ], 422);
        }

        try {
            $usuario = new Usuario();
            $usuario->nombres = $request->nombres;
            $usuario->apellidos = $request->apellidos;
            $usuario->email = $request->email;
            $usuario->contraseña = Hash::make($request->contraseña);
            $usuario->confirmar_contraseña = Hash::make($request->confirmar_contraseña);
            $usuario->tipo_documento = $request->tipo_documento;
            $usuario->numero_documento = $request->numero_documento;
            $usuario->telefono = $request->telefono;
            $usuario->save();
            return response()->json([
                'mensaje' => 'Se ha creado el usuario ' . $usuario->nombres,
                'data' => $usuario
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al agregar el usuario en la base de datos',
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
        $usuario = Usuario::findOrFail($id);
        try {
            return response()->json([
                'mensaje' => 'Se consulto el usuario ' . $usuario->nombres . ' de la base de datos',
                'data' => $usuario
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se obtuvo el usuario solicitado',
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
            'nombres' => 'required|string|max:200',
            'apellidos' => 'nullable|string|max:250',
            'email' => 'required|string|max:300|email',
            'contraseña' => 'required|string|max:500',
            'confirmar_contraseña' => 'required|string|max:500|same:contraseña',
            'tipo_documento' => 'required|string',
            'numero_documento' => 'required|string',
            'telefono' => 'required|numeric',
        ];

        $validador = Validator::make($request->all(), $reglas);
        if ($validador->fails()) {
            return response()->json([
                'error' => 'Ha ocurrido un error al validar los datos enviados',
                'mensaje' => $validador->errors()
            ], 422);
        }

        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->nombres = $request->nombres;
            $usuario->apellidos = $request->apellidos;
            $usuario->email = $request->email;
            $usuario->contraseña = Hash::make($request->contraseña);
            $usuario->confirmar_contraseña = Hash::make($request->confirmar_contraseña);
            $usuario->tipo_documento = $request->tipo_documento;
            $usuario->numero_documento = $request->numero_documento;
            $usuario->telefono = $request->telefono;
            $usuario->save();
            return response()->json([
                'mensaje' => 'Se ha actualizado el usuario ' . $usuario->nombres,
                'data' => $usuario
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al actualizar el usuario en la base de datos',
                'mensaje' => $e->getMessage()
            ], 500);
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
            $usuario = Usuario::findOrFail($id);
            $usuario->delete();
            return response()->json([
                'mensaje' => 'Se ha eliminado el usuario ' . $usuario->nombres . ' de la base de datos',
                'data' => $usuario
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se elimino el usuario deseado',
                'mensaje' => $e->getMessage()
            ], 404);
        }
    }
}
