<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;



class AuthController extends Controller
{
   /*public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }*/
   // Método para iniciar sesión
   public function login(Request $request)
   {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = usuario::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
   }


      /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        try {
            Log::info('Attempting to get user from token');
            
            $token = $request->bearerToken();
            Log::info('Received token: ' . $token);

            if (!$token) {
                Log::error('No token provided');
                return response()->json(['error' => 'No token provided'], 401);
            }

            try {
                $payload = JWTAuth::getPayload($token)->toArray();
                Log::info('Token payload:', $payload);
            } catch (\Exception $e) {
                Log::error('Error decoding token: ' . $e->getMessage());
            }

            $user = Auth::guard('api')->user();
            
            if ($user) {
                Log::info('User retrieved successfully: ' . $user->id);
                return response()->json($user);
            } else {
                Log::error('User not found for token');
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error in me() method: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener el usuario'], 500);
        }
        //return response()->json(Auth::user());
    }

   // Método para cerrar sesión
   public function logout(Request $request)
   {
            // Revocar el token actual del usuario
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Sesión cerrada exitosamente',
            ]);
    /*Auth::logout();
    return response()->json([
        'status' => 'success',
        'message' => 'Successfully logged out',
    ]);*/
   }

   // Método para refrescar el token
   public function refresh()
   {
    return response()->json([
        'status' => 'success',
        'user' => Auth::user(),
        'authorization' => [
            'token' => Auth::refresh(),
            'type' => 'bearer',
        ]
    ]);
   }


   // Responder con el token
   protected function respondWithToken($token)
   {
       return response()->json([
           'access_token' => $token,
           'token_type' => 'bearer',
           'expires_in' => Config::get('jwt.ttl') * 60,
           'user' => Auth::guard('api')->user()
       ]);
   }
}
