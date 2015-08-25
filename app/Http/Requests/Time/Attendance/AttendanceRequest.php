<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Http\Requests\Profile;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Http\Requests\Request;

/**
 * Class PersonalDetailsRequest.
 */
class PersonalDetailsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * @author Harlequin Doyon
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'user.name.first' => 'required',
                    'user.name.last'  => 'required',
                    'user.email'      => 'required|email|unique:users,email',
                    'user.password'   => 'required|confirmed',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'user.name.first' => 'required',
                    'user.name.last'  => 'required',
                    'user.email'      => 'required|email|unique:users,email,'.$user->id,
                    'user.password'   => 'required|confirmed',
                ];
            }
            default:break;
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
     * @author Harlequin Doyon
     */
    public function authorize(Sentinel $user)
    {
        $user = $user::getUser();

        $permission = Request::is('*pim/*') ? 'pim.personal-details' : 'profile.personal-details';

        // Update
        if (Request::isMethod('patch') || Request::is('*/edit')) {
            return ($user->hasAccess($permission.'.update'));
        } // View
        else {
            if (Request::isMethod('get')) {
                return ($user->hasAccess($permission.'.view'));
            }
        }
    }
}
