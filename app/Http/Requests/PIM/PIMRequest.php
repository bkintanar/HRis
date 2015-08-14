<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Http\Requests\PIM;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Http\Requests\Request;

/**
 * Class PIMRequest.
 */
class PIMRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * @author Bertrand Kintanar
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
     *
     * @return bool
     *
     * @author Bertrand Kintanar
     */
    public function authorize(Sentinel $user)
    {
        $user = $user::getUser();

        $permission = str_replace('/', '.', Request::path());

        // View
        if (Request::isMethod('get')) {
            return ($user->hasAccess($permission.'.view'));
        } // Create
        else {
            if (Request::isMethod('post')) {
                return ($user->hasAccess($permission.'.create'));
            }
        }
    }

    /**
     * @return mixed
     *
     * @author Bertrand Kintanar
     */
    public function forbiddenResponse()
    {
        return response()->make(view()->make('errors.403'), 403);
    }
}
