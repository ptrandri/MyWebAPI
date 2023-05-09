<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Check if the user is authenticated and authorized to access the requested resource
            if (!Auth::guard('sanctum')->check()) {
                throw new UnauthorizedHttpException('Unauthorized');
            }
            return $next($request);
            
        } catch (UnauthorizedHttpException $e) {
            // Return a JSON response with an appropriate error message and a 401 status code
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
    }
}
