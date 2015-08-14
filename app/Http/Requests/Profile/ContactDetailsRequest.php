<?php

namespace HRis\Http\Requests\Profile;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Http\Requests\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

/**
 * Class ContactDetailsRequest
 * @package HRis\Http\Requests\Profile
 */
class ContactDetailsRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Request::isMethod('post')) {
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

        $permission = Request::is('*pim/*') ? 'pim.contact-details' : 'profile.contact-details';

        // Update
        if (Request::isMethod('patch') || Request::is('*/edit')) {
            return ($user->hasAccess($permission . '.update'));
        } // View
        else {
            if (Request::isMethod('get')) {
                return ($user->hasAccess($permission . '.view'));
            }
        }
    }

    /**
     * @return mixed
     */
    public function forbiddenResponse()
    {
        return Response::make(View::make('errors.403'), 403);
    }

}
