<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Requests\PIM;

use HRis\Http\Requests\Request;

/**
 * Class CustomFieldRequest.
 */
class CustomFieldRequest extends Request
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
            return ['name'];
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
        $permission = 'pim.configuration.custom-fields';

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

    /**
     * @return mixed
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function forbiddenResponse()
    {
        return response()->make(view()->make('errors.403'), 403);
    }
}
