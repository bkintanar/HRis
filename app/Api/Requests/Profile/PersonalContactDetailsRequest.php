<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Requests\Profile;

use HRis\Http\Requests\Request;

/**
 * Class PersonalContactDetailsRequest.
 */
class PersonalContactDetailsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function rules()
    {
        if (Request::isMethod('patch')) {
            return [
                'employee' => [
                    'id'          => 'required',
                    'employee_id' => 'required',
                ]
            ];
        }

        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function authorize()
    {
        $permission = Request::is('*pim/*') ? 'pim' : 'profile';
        $permission .= Request::is('*personal-details*') ? '.personal-details' : '.personal-details';

        // Update
        if (Request::isMethod('patch') || Request::is('*/edit')) {
            return $this->logged_user->hasAccess($permission.'.update');
        } // View
        else {
            if (Request::isMethod('get')) {
                return $this->logged_user->hasAccess($permission.'.view');
            }
        }
    }
}
