<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Http\Requests;

use Dingo\Api\Http\FormRequest;
use HRis\Api\Eloquent\User;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class Request extends FormRequest
{
    public $app_list_limit;

    public $logged_user;

    public function __construct()
    {
        $token = JWTAuth::getToken();
        if (!empty($token)) {
            $user = JWTAuth::toUser($token);
            $this->logged_user = User::find($user->id);
        }
    }

    /**
     * Get the sort param.
     *
     * @return string
     *
     * @author Harlequin Doyon
     */
    public function sort()
    {
        return $this->get('sort') != '' ? $this->get('sort') : 'id';
    }

    /**
     * Get the direction param.
     *
     * @return string
     *
     * @author Harlequin Doyon
     */
    public function direction()
    {
        return $this->get('direction') != '' ? $this->get('direction') : 'asc';
    }

    /**
     * Check if logged user has access.
     *
     * @param $permission
     *
     * @return bool
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function hasAccess($permission)
    {
        $methods = [
            'DELETE' => $this->logged_user->hasAccess($permission.'.delete'),
            'GET'    => $this->logged_user->hasAccess($permission.'.view'),
            'PATCH'  => $this->logged_user->hasAccess($permission.'.update'),
            'POST'   => $this->logged_user->hasAccess($permission.'.create'),
        ];

        return $methods[$this->getMethod()];
    }
}
