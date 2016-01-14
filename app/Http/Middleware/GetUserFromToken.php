<?php

namespace HRis\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\GetUserFromToken as JWTGetUserFromToken;

class GetUserFromToken extends JWTGetUserFromToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return $this->respondError('token_not_provided', 403);
        }

        $user = null;

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return $this->respondError('token_expired', 400);
        } catch (JWTException $e) {
            dd($this->auth->authenticate($token));
            dd('testing');

            return $this->respondError('token_absent', 400);
        }

        if (!$user) {
            return $this->respondError('user_not_found', 404);
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }

    private function respondError($message, $code)
    {
        return response()->json([
            'message'     => $message,
            'status_code' => $code,
        ], $code);
    }
}
