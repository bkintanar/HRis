<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

namespace HRis\Http\Requests\Profile;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Http\Requests\Request;

/**
 * Class PersonalDetailsRequest
 * @package HRis\Http\Requests\Profile
 */
class PersonalDetailsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Bertrand Kintanar
     */
    public function rules()
    {
        if (Request::isMethod('post')) {
            return [
                'first_name'  => 'required',
                'last_name'   => 'required',
                'employee_id' => 'required|unique',
                'birth_date'  => 'required',
            ];
        }

        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Sentinel $user
     * @return bool
     * @author Bertrand Kintanar
     */
    public function authorize(Sentinel $user)
    {
        $user = $user::getUser();

        $permission = Request::is('*pim/*') ? 'pim.personal-details' : 'profile.personal-details';

        // Update
        if (Request::isMethod('patch') || Request::is('*/edit')) {
            return ($user->hasAccess($permission . '.update'));
        } // View
        else {
            if (Request::isMethod('get')) {
                return ($user->hasAccess($permission . '.view'));
            }
        }
    }

    /**
     * @return mixed
     * @author Bertrand Kintanar
     */
    public function forbiddenResponse()
    {
        return response()->make(view()->make('errors.403'), 403);
    }
}
