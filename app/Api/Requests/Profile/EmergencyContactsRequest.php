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
 * Class EmergencyContactsRequest.
 */
class EmergencyContactsRequest extends Request
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
        $rules = [];
        if ($this->isMethod('delete') || $this->isMethod('patch')) {
            $rules['id'] = 'exists:emergency_contacts,id';
        }
        if ($this->isMethod('post') || $this->isMethod('patch')) {
            $rules['first_name'] = 'required';
            $rules['relationship_id'] = 'required';
        }

        return $rules;
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
        $permission = $this->is('*pim/*') ? 'pim.emergency-contacts' : 'profile.emergency-contacts';

        return $this->hasAccess($permission);
    }
}
