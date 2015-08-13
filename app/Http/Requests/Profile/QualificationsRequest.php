<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

namespace HRis\Http\Requests\Profile;

use HRis\Http\Requests\Request;

/**
 * Class QualificationsRequest
 * @package HRis\Http\Requests\Profile
 */
class QualificationsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @author Bertrand Kintanar
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return mixed
     * @author Bertrand Kintanar
     */
    public function forbiddenResponse()
    {
        return response()->make(view()->make('errors.403'), 403);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Bertrand Kintanar
     */
    public function rules()
    {
        return [];
    }
}
