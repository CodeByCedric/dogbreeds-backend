<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $language = $request->input('lang', 'en');
        app()->setLocale($language);

        return $next($request);
    }
}

/*In this code, we retrieve the language parameter from the request input. If the parameter is not provided, it defaults to 'en' (English). Then, we use app()->setLocale() to set the application locale to the desired language.*/
