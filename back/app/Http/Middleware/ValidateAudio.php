<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateAudio
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->validate([
            'audio' => 'required|file|mimes:audio/m4a',
        ]);

        return $next($request);
    }
}
