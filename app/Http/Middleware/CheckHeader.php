<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckHeaders
{
    public function handle(Request $request, Closure $next)
    {
        // Check for a specific header
        if ($request->hasHeader('Authorization')) {
            // Do something with the header
            $headerValue = $request->header('Authorization');
            // Example: Add a custom header to the response
            $response = $next($request);
            return $response->header('X-Processed-Header', $headerValue);
        }

        return $next($request);
    }
}

?>