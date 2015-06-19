<?php

namespace HRis\Http\Controllers;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package HRis\Http\Controllers
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
     * @param Sentry $auth
     */
    public function __construct(Sentry $auth)
    {
        $this->auth = $auth;

        if ($auth::check()) {
            $this->data['logged_user'] = $this->logged_user = $this->auth = $auth::getUser();
        }
    }

    /**
     * @param $blade
     * @return \Illuminate\View\View
     */
    public function template($blade)
    {
        return view($blade, $this->data);
    }
}
