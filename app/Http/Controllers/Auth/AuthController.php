<?php

namespace HRis\Http\Controllers\Auth;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\Employee;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Auth\LoginRequest;
use HRis\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

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
        $this->data['page_title'] = 'Login';

        return view('auth.login', $this->data);
    }

    /**
     * Show the application register form.
     *
     * @Get("auth/register")
     *
     * @return Response
     */
    public function getRegister()
    {
        $this->data['page_title'] = 'Register';

        return view('auth.register', $this->data);
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

            if ( ! $user) {
                return redirect('/auth/login')->withInput($request->only('email'))->withErrors([
                    'email' => 'These credentials do not match our records.',
                ]);
            }

            $auth::login($user);

            return redirect()->intended('/dashboard');
        } catch (PDOException $e) {
            return redirect('/auth/login')->withInput($request->only('email'))->withErrors([
                'email' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle the activation request to the application.
     *
     * @Get("auth/activate/{user_id}/{activation_code}")
     *
     * @param $user_id
     * @param $activation_code
     * @return Redirect
     */
    public function getActivateUser($user_id, $activation_code)
    {
        $auth = $this->auth;

        $user = $auth::findById($user_id);

        // User not found
        if ( ! $user) {
            App::abort(404, 'user_not_found');
        }

        if (Activation::complete($user, $activation_code)) {
            $auth::login($user);
            return redirect('/');
        } else {
            App::abort(404, 'activation_code_invalid');
        }


    }

    /**
     * Handle a register request to the application.
     *
     * @Post("auth/register")
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(RegisterRequest $request)
    {
        $auth = $this->auth;

        $email = $request->get('email');

        $credentials = [
            'email'    => $email,
            'password' => $request->get('password'),
        ];


        $user = $auth::register($credentials);

        $role = $auth::findRoleBySlug('ess');

        $role->users()->attach($user);

        $activation = Activation::create($user);

        $email_data = [
            'first_name'      => $request->get('first_name'),
            'last_name'       => $request->get('last_name'),
            'user_id'         => $user->id,
            'email'           => $email,
            'activation_code' => $activation->code,
        ];

        // Add to queue the user activation email.
        Mail::queue('emails.activate-user', $email_data, function ($message) use ($email) {
            $message->from(env('MAIL_ADDRESS', 'mail@example.com'), env('MAIL_NAME', 'Wizard Mailer'));
            $message->to($email);
            $message->subject(trans('app.account_activation'));
        });

        $employee_data = [
            'employee_id' => Config::get('company.employee_id_prefix') . $user->id,
            'user_id'     => $user->id,
            'first_name'  => $request->get('first_name'),
            'last_name'   => $request->get('last_name'),
            'gender'      => 'M',
            'work_email'  => $request->get('email'),
        ];

        $employee = new Employee($employee_data);

        $employee->save();

        $activation_message = 'Please check your email address (' . $email . ') to activate your account.';

        return redirect('/auth/login')->with('activation', $activation_message);
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
