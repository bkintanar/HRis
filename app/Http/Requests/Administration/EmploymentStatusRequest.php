<?php

namespace HRis\Http\Requests\Administration;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Http\Requests\Request;

/**
 * Class EmploymentStatusRequest
 * @package HRis\Http\Requests\Administration
 */
class EmploymentStatusRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Request::isMethod('post') || Request::isMethod('patch')) {
            return ['name'];
        }

        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Sentinel $user
     * @return bool
     */
    public function authorize(Sentinel $user)
    {
        $user = $user::getUser();

        $permission = 'admin.job.employment-status';

        // Create
        if (Request::isMethod('post')) {
            return ($user->hasAccess($permission . '.create'));
        } // Delete
        else {
            if (Request::isMethod('delete')) {
                return ($user->hasAccess($permission . '.delete'));
            } // View
            else {
                if (Request::isMethod('get')) {
                    return ($user->hasAccess($permission . '.view'));
                } // Update
                else {
                    if (Request::isMethod('patch')) {
                        return ($user->hasAccess($permission . '.update'));
                    }
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function forbiddenResponse()
    {
        return response()->make(view()->make('errors.403'), 403);
    }
}
