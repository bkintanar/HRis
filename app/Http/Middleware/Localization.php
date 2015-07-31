<?php

namespace HRis\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

/**
 * Class Localization
 * @package HRis\Http\Middleware
 */
class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! Session::has('locale')) {
            Session::put('locale', Config::get('app.locale'));
        }

        app()->setLocale(Session::get('locale'));

        return $next($request);
    }
}
