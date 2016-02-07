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
 * Class DependentsRequest.
 */
class DependentsRequest extends Request
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
        if ($this->isMethod('post') || $this->isMethod('patch')) {
            return ['first_name', 'relationship_id'];
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
        $permission = $this->is('*pim/*') ? 'pim.dependents' : 'profile.dependents';

        // Create
        if ($this->isMethod('post')) {
            return $this->logged_user->hasAccess($permission.'.create');
        } // Delete
        else {
            if ($this->isMethod('delete')) {
                return $this->logged_user->hasAccess($permission.'.delete');
            } // View
            else {
                if ($this->isMethod('get')) {
                    return $this->logged_user->hasAccess($permission.'.view');
                } // Update
                else {
                    if ($this->isMethod('patch')) {
                        return $this->logged_user->hasAccess($permission.'.update');
                    }
                }
            }
        }
    }
}
