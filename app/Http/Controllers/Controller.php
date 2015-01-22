<?php namespace HRis\Http\Controllers;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

    public $loggedUser;

    protected $auth;

    public $data = [];

    public function __construct(Sentry $auth)
    {
        $this->auth = $auth;

        if ($auth::check())
        {
            $this->data['loggedUser'] = $this->loggedUser = $auth::getUser();
        }
    }

    public function template($blade)
    {
        return view($blade, $this->data);
    }
}
