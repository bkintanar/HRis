<?php

namespace HRis\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Http\RedirectResponse;

/**
 * Class RedirectIfAuthenticated
 * @package HRis\Http\Middleware
 */
class RedirectIfAuthenticated
{

    /**
     * The Sentinel implementation.
     *
     * @var Sentinel
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Sentinel $auth
     */
    public function __construct(Sentinel $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = $this->auth;

        if ($auth::check()) {
            return new RedirectResponse(url('/home'));
        }

        return $next($request);
    }

}
