<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Request.
 */
abstract class Request extends FormRequest
{
    /**
     * @return mixed
     *
     * @author Bertrand Kintanar
     */
    public function forbiddenResponse()
    {
        return response()->make(view()->make('errors.403'), 403);
    }
}
