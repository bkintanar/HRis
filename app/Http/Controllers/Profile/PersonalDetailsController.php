<?php

namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Exception;
use HRis\Eloquent\Employee;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\PersonalDetailsRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

/**
 * Class PersonalDetailsController
 * @package HRis\Http\Controllers\Profile
 *
 * @Middleware("auth")
 */
class PersonalDetailsController extends Controller
{

    /**
     * @var
     */
    protected $employee;

    /**
     * @param Sentry $auth
     * @param Employee $employee
     */
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
     *
     * @return \Illuminate\View\View
     */
    public function index(PersonalDetailsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->logged_user->id);

        if ( ! $employee) {
            return Response::make(View::make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $this->data['disabled'] = 'disabled';
        $this->data['pim'] = $request->is('*pim/*') ? : false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Personal Details' : 'My Personal Details';

        return $this->template('pages.profile.personal-details.view');
    }

    /**
     * Show the Profile - Personal Details Form.
     *
     * @Get("profile/personal-details/edit")
     * @Get("pim/employee-list/{id}/personal-details/edit")
     *
     * @param PersonalDetailsRequest $request
     * @param null $employee_id
     *
     * @return \Illuminate\View\View
     */
    public function show(PersonalDetailsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->logged_user->id);

        if ( ! $employee) {
            return Response::make(View::make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $this->data['disabled'] = '';
        $this->data['pim'] = $request->is('*pim/*') ? : false;
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
    public function update(PersonalDetailsRequest $request)
    {
        $id = $request->get('id');
        $employee_id = $request->get('employee_id');

        $employee = $this->employee->whereId($id)->first();

        if ( ! $employee) {
            return Redirect::to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        // If user is trying to update the employee_id to a used employee_id.
        $original_employee_id = $this->employee->whereEmployeeId($employee_id)->pluck('id');
        if ($id != $original_employee_id && ! is_null($original_employee_id)) {
            $path = $request->path();

            // pim/employee-list/{id}/personal-details
            if ($request->is('*pim/*')) {
                $path = explode('/', $path);
                $path[2] = $employee->employee_id;
                $path = implode('/', $path);
            }

            return Redirect::to($path)->with('danger', 'Employee Id already in use.');
        }

        try {
            $employee->update($request->all());

        } catch (Exception $e) {
            return Redirect::to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
