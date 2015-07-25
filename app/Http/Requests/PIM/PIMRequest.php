<?php

namespace HRis\Http\Requests\PIM;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Http\Requests\Request;

/**
 * Class PIMRequest
 * @package HRis\Http\Requests\PIM
 */
class PIMRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Request::isMethod('post')) {
            return [];
        }

        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Sentinel $user
     * @return bool
     */
    public function authorize(Sentinel $user)
    {
        $user = $user::getUser();

        $permission = str_replace('/', '.', Request::path());

        // View
        if (Request::isMethod('get')) {
            return ($user->hasAccess($permission . '.view'));
        } // Create
        else {
            if (Request::isMethod('post')) {
                return ($user->hasAccess($permission . '.create'));
            }
        }
    }

    /**
     * @return mixed
     */
    public function forbiddenResponse()
    {
        return response()->make(view()->make('errors.403'), 403);
    }

}
