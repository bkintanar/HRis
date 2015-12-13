<?php

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
}
