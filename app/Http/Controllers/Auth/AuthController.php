<?php

namespace HRis\Http\Controllers\Auth;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Redirect;

/**
 * Class AuthController
 * @package HRis\Http\Controllers\Auth
 */
class AuthController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    /**
     * Show the application login form.
     *
     * @Get("auth/login")
     *
     * @return Response
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @Post("auth/login")
     *
     * @param  LoginRequest $request
     * @return Response
     */
    public function postLogin(LoginRequest $request)
    {
        $auth = $this->auth;

        try {
            $user = $auth::authenticate($request->only('email', 'password'), false);

            if ($user) {

                $auth::login($user);

                return Redirect::intended('/dashboard');
            }
        } catch (PDOException $e) {
            return redirect('/auth/login')->withInput($request->only('email'))->withErrors([
                'email' => $e->getMessage(),
            ]);
        } catch (Exception $e) {
            return redirect('/auth/login')->withInput($request->only('email'))->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);

        }
    }

    /**
     * Log the user out of the application.
     *
     * @Get("auth/logout")
     *
     * @return Response
     */
    public function getLogout()
    {
        Sentinel::logout();

        return redirect('/');
    }
}
