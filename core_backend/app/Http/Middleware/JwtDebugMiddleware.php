<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;

class JwtDebugMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info('JwtDebugMiddleware: Starting token validation');

        try {
            $token = JWTAuth::parseToken();
            
            if (!$token->authenticate()) {
                Log::error('JwtDebugMiddleware: Token authentication failed');
                return response()->json(['error' => 'User not found'], 404);
            }

            Log::info('JwtDebugMiddleware: Token validated successfully');
        } catch (TokenExpiredException $e) {
            Log::error('JwtDebugMiddleware: Token has expired');
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (TokenInvalidException $e) {
            Log::error('JwtDebugMiddleware: Token is invalid');
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (\Exception $e) {
            Log::error('JwtDebugMiddleware: ' . $e->getMessage());
            return response()->json(['error' => 'Authorization Token not found'], 401);
        }

        return $next($request);
    }
}