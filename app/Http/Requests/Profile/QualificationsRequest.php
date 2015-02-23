<?php namespace HRis\Http\Requests\Profile;

use HRis\Http\Requests\Request;
use Illuminate\Support\Facades\View;

class QualificationsRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function forbiddenResponse()
    {
        return Response::make(View::make('errors.403'), 403);
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
