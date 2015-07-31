<?php

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
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function forbiddenResponse()
    {
        return response()->make(view()->make('errors.403'), 403);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
