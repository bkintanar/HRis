<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

namespace HRis\Http\Requests\Auth;

use HRis\Http\Requests\Request;

/**
 * Class LoginRequest
 * @package HRis\Http\Requests\Auth
 */
class LoginRequest extends Request
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Bertrand Kintanar
     */
    public function rules()
    {
        return [
            'email'    => 'required',
            'password' => 'required',
        ];
    }
}
