<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenPowerBi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd('Unauthorized');
        //a98c8df6-41c7-4e6a-b84c-908dd5a04b91f10fdacc-4f0b-47d3-b006-1a7107a2c0914fbdd0e8-9571-4a5f-bc0b-1ff7895a0b48
        $token = $request->header('API-KEY');
        if ($token != env('POWER_BI_KEY')) {
            # code...
            
            return response()->json(['code' => 401, 'message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
