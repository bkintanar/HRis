<?php

namespace HRis\Http\Middleware;

use Carbon\Carbon;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\RefreshToken as JWTRefreshToken;

class RefreshToken extends JWTRefreshToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        try {
            $token = $this->generateToken($request);
        } catch (TokenExpiredException $e) {
            return $this->respondError('token_expired', 400);
        } catch (JWTException $e) {
            return $this->respondError('token_absent', 400);
        }

        // send the refreshed token back to the client
        $response->headers->set('Authorization', $token);

        return $response;
    }

    /**
     * Generate the token.
     *
     * @return string
     *
     * @author Harlequin Doyon
     */
    private function generateToken($request)
    {
        $old_token = $this->auth->setRequest($request)->getToken();
        $user = $this->auth->toUser($old_token);

        if ($user->remember_me) {
            $expiry = Carbon::now()->addYear()->format('U');

            return $this->auth->fromUser($user, ['exp' => $expiry]);
        }

        return $this->auth->parseToken()->refresh();
    }

    private function respondError($message, $code)
    {
        return response()->json([
            'message'     => $message,
            'status_code' => $code,
        ], $code);
    }
}
