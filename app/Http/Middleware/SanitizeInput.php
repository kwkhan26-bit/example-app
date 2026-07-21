<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        // Notice we added $key here so we can check the name of the input
        array_walk_recursive($input, function (&$value, $key) {
            
            // If it's a string AND the field name is NOT 'password' or 'password_confirmation'
            if (is_string($value) && !in_array(strtolower($key), ['password', 'password_confirmation'])) {
                $value = strip_tags($value);
            }
            
        });

        $request->merge($input);

        return $next($request);
    }
}