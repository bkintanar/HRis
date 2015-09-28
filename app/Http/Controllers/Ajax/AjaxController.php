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

        if ($this->logged_user) {
            $this->employee = $this->logged_user->employee;
        }
    }

    protected function response($title, $text, $data = [], $level = 'success')
    {
        return response()->json(array_merge([
            'title' => $title,
            'text'  => $text,
            'level' => $level,
        ], $data));
    }
}
