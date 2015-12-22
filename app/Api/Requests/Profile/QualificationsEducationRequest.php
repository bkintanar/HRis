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
 * Class QualificationsEducationRequest.
 */
class QualificationsEducationRequest extends Request
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
     * @return bool
     *
     * @author Bertrand Kintanar
     */
    public function authorize()
    {
        $permission = Request::is('*pim/*') ? 'pim.qualifications.educations' : 'profile.qualifications.educations';

        // Create
        if (Request::isMethod('post')) {
            return $this->logged_user->hasAccess($permission.'.create');
        } // Delete
        else {
            if (Request::isMethod('delete')) {
                return $this->logged_user->hasAccess($permission.'.delete');
            } // View
            else {
                if (Request::isMethod('get')) {
                    return $this->logged_user->hasAccess($permission.'.view');
                } // Update
                else {
                    if (Request::isMethod('patch')) {
                        return $this->logged_user->hasAccess($permission.'.update');
                    }
                }
            }
        }
    }
}
