<?php namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Exception;
use HRis\Employee;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\PersonalDetailsRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

/**
 * @Middleware("auth")
 */
class PersonalDetailsController extends Controller {

    protected $user;

    public function __construct(Sentry $auth, Employee $employee)
    {
        parent::__construct($auth);

        $this->employee = $employee;
    }

    /**
     * Show the Profile - Personal Details.
     *
     * @Get("profile/personal-details")
     * @Get("pim/employee-list/{id}/personal-details")
     *
     * @param PersonalDetailsRequest $request
     * @param null $employee_id
     * @return \Illuminate\View\View
     */
    public function personalDetails(PersonalDetailsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->loggedUser->id);

        if ( ! $employee)
        {
            return Response::make(View::make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $this->data['disabled'] = 'disabled';
        $this->data['pim'] = $request->is('*pim/*') ? true : false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Personal Details' : 'My Personal Details';

        return $this->template('pages.profile.personal-details.view');
    }

    /**
     * Show the Profile - Personal Details Form.
     *
     * @Get("profile/personal-details/edit")
     * @Get("pim/employee-list/{id}/personal-details/edit")
     * @param PersonalDetailsRequest $request
     * @param null $employee_id
     * @return \Illuminate\View\View
     */
    public function showPersonalDetailsEditForm(PersonalDetailsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->loggedUser->id);

        if ( ! $employee)
        {
            return Response::make(View::make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $this->data['disabled'] = '';
        $this->data['pim'] = $request->is('*pim/*') ? true : false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Edit Employee Contact Details' : 'Edit My Contact Details';

        return $this->template('pages.profile.personal-details.edit');
    }

    /**
     * Update the Profile - Personal Details.
     *
     * @Patch("profile/personal-details")
     * @Patch("pim/employee-list/{id}/personal-details")
     *
     * @param PersonalDetailsRequest $request
     */
    public function updatePersonalDetails(PersonalDetailsRequest $request)
    {
        $id = $request->get('id');
        $employee_id = $request->get('employee_id');

        $employee = $this->employee->whereId($id)->first();

        if ( ! $employee)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }


        $original_id = $this->employee->whereEmployeeId($employee_id)->pluck('id');
        if ($id != $original_id && ! is_null($original_id))
        {
            $path = $request->path();

            // pim/employee-list/{id}/personal-details
            if ($request->is('*pim/*'))
            {
                $path = explode('/', $path);
                $path[2] = $employee->employee_id;
                $path = implode('/', $path);
            }

            return Redirect::to($path)->with('danger', 'Employee Id already in use.');
        }

        try
        {
            $employee->employee_id = $request->get('employee_id') ? $request->get('employee_id') : null;
            $employee->face_id = $request->get('face_id') ? $request->get('face_id') : null;
            $employee->first_name = $request->get('first_name');
            $employee->middle_name = $request->get('middle_name');
            $employee->last_name = $request->get('last_name');
            $employee->gender = $request->get('gender');
            $employee->birth_date = $request->get('birth_date');
            $employee->social_security = $request->get('social_security');
            $employee->tax_identification = $request->get('tax_identification');
            $employee->philhealth = $request->get('philhealth');
            $employee->hdmf_pagibig = $request->get('hdmf_pagibig');
            $employee->marital_status_id = $request->get('marital_status_id');
            $employee->nationality_id = $request->get('nationality_id');

            $employee->save();
        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
