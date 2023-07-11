<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $language = $request->input('lang', 'en');
        app()->setLocale($language);

        return $next($request);
    }
}

/*In this code, we retrieve the language parameter from the request input. If the parameter is not provided, it defaults to 'en' (English). Then, we use app()->setLocale() to set the application locale to the desired language.*/
