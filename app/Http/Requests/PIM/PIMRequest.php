<?php namespace HRis\Http\Requests\PIM;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Http\Requests\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class PIMRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Request::isMethod('post'))
        {
            return [];
        }

        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Sentry $user
     * @return bool
     */
    public function authorize(Sentry $user)
    {
        $user = $user::getUser();

        $permission = str_replace('/', '.', Request::path());

        // View
        if (Request::isMethod('get'))
        {
            return ($user->hasAccess($permission . '.view'));
        }
        // Create
        else if (Request::isMethod('post'))
        {
            return ($user->hasAccess($permission . '.create'));
        }
    }

    public function forbiddenResponse()
    {
        return Response::make(View::make('errors.403'), 403);
    }

}
