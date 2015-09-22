<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Http\RedirectResponse;

/**
 * Class RedirectIfAuthenticated.
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
     * @param Sentinel $auth
     *
     * @author Bertrand Kintanar
     */
    public function __construct(Sentinel $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     *
     * @author Bertrand Kintanar
     */
    public function handle($request, Closure $next)
    {
        $auth = $this->auth;

        if ($auth::check()) {
            return new RedirectResponse(url('/'));
        }

        return $next($request);
    }
}
