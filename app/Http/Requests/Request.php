<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Http\Requests;

use HRis\Api\Eloquent\User;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class Request extends FormRequest
{
    public function __construct()
    {
        $this->app_list_limit = env('APP_LIST_LIMIT', 50);
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
}
