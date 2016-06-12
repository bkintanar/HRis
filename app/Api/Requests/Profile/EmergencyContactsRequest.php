<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
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
