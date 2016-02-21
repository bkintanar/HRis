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
 * Class QualificationsWorkExperienceRequest.
 */
class QualificationsWorkExperienceRequest extends Request
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
        $permission = $this->is('*pim/*') ? 'pim.qualifications.work-experiences' : 'profile.qualifications.work-experiences';

        return $this->hasAccess($permission);
    }
}
