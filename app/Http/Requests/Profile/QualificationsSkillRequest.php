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
 * Class QualificationsSkillRequest.
 */
class QualificationsSkillRequest extends Request
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

        $permission = Request::is('*pim/*') ? 'pim.qualifications.skills' : 'profile.qualifications.skills';

        // Create
        if (Request::isMethod('post')) {
            return ($user->hasAccess($permission.'.create'));
        } // Delete
        else {
            if (Request::isMethod('delete')) {
                return ($user->hasAccess($permission.'.delete'));
            } // View
            else {
                if (Request::isMethod('get')) {
                    return ($user->hasAccess($permission.'.view'));
                } // Update
                else {
                    if (Request::isMethod('patch')) {
                        return ($user->hasAccess($permission.'.update'));
                    }
                }
            }
        }
    }
}
