<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Http\Controllers;

use HRis\Eloquent\Employee;
use HRis\Eloquent\Timelog;

/**
 * Class HomeController.
 *
 * @Middleware("auth")
 */
class HomeController extends Controller
{
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
     * @author Bertrand Kintanar
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
     *
     * @author Bertrand Kintanar
     */
    public function index()
    {
        return redirect()->to('/dashboard');
    }

    /**
     * @Get("sandbox")
     *
     * @author Bertrand Kintanar
     */
    public function sandbox()
    {
        // Show attendance of a given employee

        $employee = Employee::whereId(3)->first();

        $timelog = Timelog::where('swipe_date', '>=', '2015-01-01')->where('swipe_date', '<=',
            '2015-01-31')->whereFaceId($employee->face_id)->get();

        dd($timelog);

        $this->data['pageTitle'] = 'Dashboard';

        return $this->template('pages.home');
    }
}
