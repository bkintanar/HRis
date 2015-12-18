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
     * @return bool
     *
     * @author Bertrand Kintanar
     */
    public function authorize()
    {
        $permission = str_replace('/', '.', Request::path());
        $permission = substr($permission, 4);

        // View
        if (Request::isMethod('get')) {
            return ($this->logged_user->hasAccess($permission.'.view'));
        } // Create
        else {
            if (Request::isMethod('post')) {
                return ($this->logged_user->hasAccess($permission.'.create'));
            }
        }
    }
}
