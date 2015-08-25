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
 * Class TerminationReasonsRequest.
 */
class TerminationReasonsRequest extends Request
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
        if (Request::isMethod('post') || Request::isMethod('patch')) {
            return ['name'];
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

        $permission = 'pim.configuration.termination-reasons';

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
