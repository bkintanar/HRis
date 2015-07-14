<?php

namespace HRis\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;

/**
 * Class Authenticate
 * @package HRis\Http\Middleware
 */
class Authenticate
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

        if ( ! $auth::check()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        }

        return $next($request);
    }

}
