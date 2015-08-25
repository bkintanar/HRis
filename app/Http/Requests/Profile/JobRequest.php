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
 * Class JobRequest.
 */
class JobRequest extends Request
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

        $permission = Request::is('*pim/*') ? 'pim.job' : 'profile.job';

        // Update
        if (Request::isMethod('patch') || Request::is('*/edit')) {
            return ($user->hasAccess($permission.'.update'));
        } // View
        else {
            if (Request::isMethod('get')) {
                return ($user->hasAccess($permission.'.view'));
            } else {
                if (Request::isMethod('delete')) {
                    return ($user->hasAccess($permission.'.delete'));
                }
            }
        }
    }
}
