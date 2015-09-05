<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller.
 */
abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * @var
     */
    public $logged_user;

    /**
     * @var array
     */
    public $data = [];

    /**
     * @var
     */
    public $auth;

    /**
     * @param Sentinel $auth
     *
     * @author Bertrand Kintanar
     */
    public function __construct(Sentinel $auth)
    {
        $this->auth = $auth;

        if ($auth::check()) {
            $this->data['logged_user'] = $this->logged_user = $this->auth = $auth::getUser();
        }
    }

    /**
     * @param $blade
     *
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar
     */
    public function template($blade)
    {
        return view($blade, $this->data);
    }

    /**
     * Another way in adding some data in the view.
     *
     * @param array $arr
     *
     * @return this
     *
     * @author Harlequin Doyon
     */
    public function data($arr)
    {
        $this->data = array_merge($this->data, $arr);

        return $this;
    }
}
