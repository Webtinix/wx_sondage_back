<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {  
        try {
            if (empty(auth()->user())) {
                # code...
                return response()->json(['code' => 401, 'message' => 'Vous devez vous connecter' ]);
            }
            return $request->expectsJson();
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }
}
