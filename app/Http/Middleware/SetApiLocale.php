<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetApiLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = config('locales.supported', ['az']);
        $default = config('locales.default', 'az');

        $candidate = $request->header('X-Locale')
            ?? $request->query('locale')
            ?? $default;

        $locale = in_array($candidate, $supported, true) ? $candidate : $default;
        app()->setLocale($locale);

        return $next($request);
    }
}
