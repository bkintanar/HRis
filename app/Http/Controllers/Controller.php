<?php namespace HRis\Http\Controllers;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package HRis\Http\Controllers
 */
abstract class Controller extends BaseController {

    use DispatchesCommands, ValidatesRequests;

    /**
     * @var
     */
    public $loggedUser;

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

        if ($auth::check())
        {
            $this->data['loggedUser'] = $this->loggedUser = $this->auth = $auth::getUser();
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
