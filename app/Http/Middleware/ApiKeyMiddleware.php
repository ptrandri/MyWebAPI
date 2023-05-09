<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('Authorization');
        
        if (!$apiKey) {
            return response()->json(['error' => 'API key not provided'], 401);
        }
        
        $user = Auth::guard('sanctum')->user();
        
        if (!$user || $user->api_token !== $apiKey) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        return $next($request);
    }
}
