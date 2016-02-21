<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
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
        if ($this->isMethod('patch')) {
            return [
                'employee.id'          => 'required|exists:employees,id',
                'employee.employee_id' => 'required',
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
        $permission = $this->is('*pim/*') ? 'pim' : 'profile';
        $permission .= $this->is('*personal-details*') ? '.personal-details' : '.personal-details';

        return $this->hasAccess($permission);
    }
}
