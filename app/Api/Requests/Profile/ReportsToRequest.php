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
 * Class ReportsToRequest.
 */
class ReportsToRequest extends Request
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
            return [
                'employee_id'   => [
                    'required',
                    'unique_with:employee_supervisors,supervisor_id',
                ],
                'supervisor_id' => [
                    'required',
                    'unique_with:employee_supervisors,employee_id',
                    'different:employee_id',
                ],
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
        $permission = $this->is('*pim/*') ? 'pim.reports-to' : 'profile.reports-to';

        return $this->hasAccess($permission);
    }
}
