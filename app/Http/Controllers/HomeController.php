<?php namespace HRis\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class HomeController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * @Get("/dashboard")
     *
     */
    public function dashboard()
    {
        $this->data['pageTitle'] = 'Dashboard';

        return $this->template('pages.home');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @Get("/")
     */
    public function index()
    {
        return Redirect::to('/dashboard');
    }

}
