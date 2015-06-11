<?php

namespace HRis\Http\Middleware;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Closure;
use Illuminate\Http\RedirectResponse;

/**
 * Class RedirectIfAuthenticated
 * @package HRis\Http\Middleware
 */
class RedirectIfAuthenticated
{

    /**
     * The Sentry implementation.
     *
     * @var Sentry
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Sentry $auth
     */
    public function __construct(Sentry $auth)
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
