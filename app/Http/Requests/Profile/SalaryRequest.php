<?php namespace HRis\Http\Requests\Profile;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Http\Requests\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class SalaryRequest extends Request {

    public function fillables()
    {
        return [
            'employee_id',
            'component_id',
            'value',
            'effective_date',
        ];
    }

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

        $permission = Request::is('*pim/*') ? 'pim.salary' : 'profile.salary';

        // Update
        if (Request::isMethod('patch') || Request::is('*/edit'))
        {
            return ($user->hasAccess($permission . '.update'));
        } // View
        else if (Request::isMethod('get'))
        {
            return ($user->hasAccess($permission . '.view'));
        }
        else if (Request::isMethod('delete'))
        {
            return ($user->hasAccess($permission . '.delete'));
        }
    }

    public function forbiddenResponse()
    {
        return Response::make(View::make('errors.403'), 403);
    }

}
