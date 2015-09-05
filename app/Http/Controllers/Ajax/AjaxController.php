<?php

namespace HRis\Http\Controllers\Ajax;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Http\Controllers\Controller;

/**
 * Class AjaxController.
 *
 * @Middleware("auth")
 */
class AjaxController extends Controller
{
    /**
     * Current Employee.
     *
     * @var Employee
     */
    protected $employee;

    public function __construct(Sentinel $auth)
    {
        parent::__construct($auth);

        if ($this->auth) {
            $this->employee = $this->auth->employee;
        }
    }

    protected function response($title, $text, $level = 'success')
    {
        return response()->json([
            'title' => $title,
            'text'  => $text,
            'level' => $level,
        ]);
    }
}
